document.addEventListener('DOMContentLoaded', () => {
    const sucursalSelect = document.getElementById('sucursal');
    const calendarioDiv = document.getElementById('calendario');
    const horariosDiv = document.getElementById('horarios-disponibles');
    const agendarBtn = document.getElementById('btn-agendar');

    let currentDate = new Date();
    let selectedDate = null;
    let selectedSlot = null;

    // --- Load Branches and Treatments ---
    function loadInitialData() {
        // Load Branches (this should come from an endpoint in the future)
        const sucursales = [
            { id: 1, nombre: 'Sede Caudillos' },
            { id: 2, nombre: 'Sede Montevideo Shopping' },
            { id: 3, nombre: 'Sede Nuevo Centro' },
            { id: 4, nombre: 'Sede Carrasco' },
            { id: 5, nombre: 'Sede Lagomar' },
            { id: 6, nombre: 'Sede Atlántida' },
            { id: 7, nombre: 'Sede Colonia' },
            { id: 8, nombre: 'Sede Libertad' },
            { id: 9, nombre: 'Sede Punta del Este' },
            { id: 10, nombre: 'Sede Las Piedras' }
        ];
        sucursales.forEach(s => {
            const option = document.createElement('option');
            option.value = s.id;
            option.textContent = s.nombre;
            sucursalSelect.appendChild(option);
        });

    }

    // --- Calendar Logic ---
    function renderCalendar() {
        calendarioDiv.innerHTML = '';
        const month = currentDate.getMonth();
        const year = currentDate.getFullYear();

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();

        const calendarHeader = document.createElement('div');
        calendarHeader.className = 'calendar-header';
        calendarHeader.innerHTML = `
            <button id="prev-month"><</button>
            <span id="month-year">${firstDay.toLocaleString('es-ES', { month: 'long', year: 'numeric' })}</span>
            <button id="next-month">></button>
        `;
        calendarioDiv.appendChild(calendarHeader);

        const table = document.createElement('table');
        table.className = 'calendar';
        const thead = document.createElement('thead');
        thead.innerHTML = '<tr><th>Dom</th><th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th></tr>';
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        let date = 1;
        for (let i = 0; i < 6; i++) {
            const row = document.createElement('tr');
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay.getDay()) {
                    row.innerHTML += '<td></td>';
                } else if (date > daysInMonth) {
                    break;
                } else {
                    const cell = document.createElement('td');
                    cell.textContent = date;
                    cell.classList.add('day');
                    const today = new Date();
                    if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                        cell.classList.add('today');
                    }
                    
                    const cellDate = new Date(year, month, date);
                    if (cellDate < today.setHours(0,0,0,0)) {
                        cell.classList.add('disabled');
                    } else {
                        cell.dataset.date = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                    }

                    row.appendChild(cell);
                    date++;
                }
            }
            tbody.appendChild(row);
            if (date > daysInMonth) break;
        }
        table.appendChild(tbody);
        calendarioDiv.appendChild(table);

        document.getElementById('prev-month').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });
        document.getElementById('next-month').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
    }

    // --- Schedule Logic ---
    function fetchAvailableSlots(date, sucursalId) {
        horariosDiv.innerHTML = '<p>Cargando horarios...</p>';
        const url = `../back/get_available_slots.php?fecha=${date}&id_sucursal=${sucursalId}`;
        
        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Error al cargar los horarios.');
                return response.json();
            })
            .then(data => {
                horariosDiv.innerHTML = '';
                if (data.error) {
                    horariosDiv.innerHTML = `<p>${data.error}</p>`;
                    return;
                }
                if (data.available_slots && data.available_slots.length > 0) {
                    const slotsContainer = document.createElement('div');
                    slotsContainer.className = 'time-slots';
                    data.available_slots.forEach(slot => {
                        const slotDiv = document.createElement('div');
                        slotDiv.className = 'time-slot';
                        slotDiv.textContent = slot;
                        slotDiv.dataset.slot = slot;
                        slotsContainer.appendChild(slotDiv);
                    });
                    horariosDiv.appendChild(slotsContainer);
                } else {
                    horariosDiv.innerHTML = '<p>No hay horarios disponibles para este día.</p>';
                }
            })
            .catch(error => {
                horariosDiv.innerHTML = `<p>${error.message}</p>`;
            });
    }
    
    // --- Scheduling Logic ---
    function bookAppointment() {
        if (!selectedDate || !selectedSlot || !sucursalSelect.value) {
            alert('Por favor, seleccione una sucursal, un día y una hora.');
            return;
        }

        // Verify that the selected slot is available
        const availableSlots = document.querySelectorAll('.time-slot');
        let slotExists = false;
        availableSlots.forEach(slot => {
            if (slot.dataset.slot === selectedSlot) {
                slotExists = true;
            }
        });

        if (!slotExists) {
            alert('La hora seleccionada no está disponible para esta sucursal. Por favor, seleccione otra hora.');
            selectedSlot = null;
            agendarBtn.classList.add('disabled');
            agendarBtn.disabled = true;
            return;
        }

        const fechaCita = `${selectedDate} ${selectedSlot}`;
        const data = {
            fecha_cita: fechaCita,
            id_sucursal: sucursalSelect.value
        };

        agendarBtn.disabled = true;
        agendarBtn.textContent = 'Agendando...';

        fetch('../back/save_appointment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                // Reset selection
                selectedDate = null;
                selectedSlot = null;
                renderCalendar();
                horariosDiv.innerHTML = '<p>Por favor, seleccione una sucursal y un día para ver los horarios disponibles.</p>';
                agendarBtn.classList.add('disabled');
            } else {
                throw new Error(result.error || 'Ocurrió un error al agendar la cita.');
            }
        })
        .catch(error => {
            alert(error.message);
        })
        .finally(() => {
            agendarBtn.disabled = false;
            agendarBtn.textContent = 'Agendar Cita';
        });
    }


    // --- Event Listeners ---
    sucursalSelect.addEventListener('change', () => {
        // Clear time selection when changing branch
        selectedSlot = null;
        document.querySelectorAll('.time-slot.selected').forEach(s => s.classList.remove('selected'));
        agendarBtn.classList.add('disabled');
        agendarBtn.disabled = true;

        if (selectedDate) {
            fetchAvailableSlots(selectedDate, sucursalSelect.value);
        } else {
            horariosDiv.innerHTML = '<p>Por favor, seleccione un día para ver los horarios disponibles.</p>';
        }
    });

    calendarioDiv.addEventListener('click', (e) => {
        if (e.target.classList.contains('day') && !e.target.classList.contains('disabled')) {
            document.querySelectorAll('.day.selected').forEach(d => d.classList.remove('selected'));
            e.target.classList.add('selected');
            selectedDate = e.target.dataset.date;
            selectedSlot = null;
            agendarBtn.classList.add('disabled');
            agendarBtn.disabled = true;
            fetchAvailableSlots(selectedDate, sucursalSelect.value);
        }
    });

    horariosDiv.addEventListener('click', (e) => {
        if (e.target.classList.contains('time-slot')) {
            document.querySelectorAll('.time-slot.selected').forEach(s => s.classList.remove('selected'));
            e.target.classList.add('selected');
            selectedSlot = e.target.dataset.slot;
            agendarBtn.classList.remove('disabled');
            agendarBtn.disabled = false;
        }
    });
    
    agendarBtn.addEventListener('click', bookAppointment);

    // --- Initialization ---
    loadInitialData();
    renderCalendar();
});