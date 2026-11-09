document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const addForm = document.getElementById('add-form');
    const resultsBody = document.getElementById('results');
    const avgSalaryEl = document.getElementById('avg-salary');

    const escapeHtml = (unsafe) => {
        return (unsafe || '').toString()
             .replace(/&/g, "&amp;")
             .replace(/</g, "&lt;")
             .replace(/>/g, "&gt;")
             .replace(/"/g, "&quot;")
             .replace(/'/g, "&#039;");
    };

    const loadList = async (query = '') => {
        try {
            const response = await fetch(`api_list.php?q=${encodeURIComponent(query)}`);
            if (!response.ok) throw new Error('Мережева помилка при завантаженні даних');
            
            const data = await response.json();
            
            avgSalaryEl.textContent = `$${data.avg_salary.toFixed(2)}`;
            
            resultsBody.innerHTML = '';
            data.vacancies.forEach(v => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <strong>${escapeHtml(v.title)}</strong>
                        <div class="text-muted">${escapeHtml(v.company)}</div>
                    </td>
                    <td class="salary-cell">
                        $${escapeHtml(String(v.salary_from))} – $${escapeHtml(String(v.salary_to))}
                    </td>
                `;
                resultsBody.appendChild(tr);
            });
        } catch (err) {
            resultsBody.innerHTML = `<tr><td colspan="2" class="error-text">${escapeHtml(err.message)}</td></tr>`;
        }
    };

    searchInput.addEventListener('input', (e) => {
        loadList(e.target.value.trim());
    });

    addForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            title: document.getElementById('title').value.trim(),
            company: document.getElementById('company').value.trim(),
            salary_from: document.getElementById('salary_from').value,
            salary_to: document.getElementById('salary_to').value
        };

        try {
            const response = await fetch('api_add.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                const err = await response.json().catch(() => ({}));
                throw new Error(err.error || 'Помилка сервера при додаванні запису');
            }

            addForm.reset();
            loadList(searchInput.value.trim());
        } catch (err) {
            resultsBody.innerHTML = `<tr><td colspan="2" class="error-text">${escapeHtml(err.message)}</td></tr>`;
        }
    });

    loadList();
});