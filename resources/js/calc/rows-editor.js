/**
 * Editable rows of numbers (<x-calc.rows-editor>). The hidden textarea holds the values, one row
 * per line separated by spaces; the inputs are a view of it, rebuilt when an example or reset
 * changes the textarea.
 */
export function parseRows(text) {
    return String(text ?? '')
        .split('\n')
        .map((line) => line.trim())
        .filter(Boolean)
        // Editors with text columns separate cells with tabs, so names may contain spaces.
        .map((line) => (line.includes('\t') ? line.split('\t').map((value) => value.trim()) : line.split(/\s+/)).map((value) => (value === '-' ? '' : value)));
}

export function initRowsEditor(editor) {
    const store = editor.querySelector('textarea');
    const body = editor.querySelector('[data-rows-body]');
    const template = editor.querySelector('[data-rows-template]');
    const columns = template.content.querySelectorAll('input').length;
    const separator = editor.hasAttribute('data-rows-text') ? '\t' : ' ';

    const renumber = () => {
        body.querySelectorAll('tr').forEach((row, index) => {
            row.querySelector('[data-row-number]').textContent = index + 1;
            row.querySelectorAll('input').forEach((input) => {
                input.setAttribute('aria-label', `Row ${index + 1} ${input.dataset.column}`);
            });
            row.querySelector('[data-row-remove]').setAttribute('aria-label', `Remove row ${index + 1}`);
        });
    };

    const addRow = (values = []) => {
        const row = template.content.firstElementChild.cloneNode(true);
        row.querySelectorAll('input').forEach((input, index) => {
            input.value = values[index] ?? '';
        });
        body.append(row);

        return row;
    };

    const save = () => {
        store.value = [...body.querySelectorAll('tr')]
            .map((row) => [...row.querySelectorAll('input')].map((input) => (input.value.trim() === '' ? '-' : input.value.trim().replace(/\s+/g, separator === ' ' ? '' : ' '))).join(separator))
            .join('\n');
    };

    const render = () => {
        body.replaceChildren();
        const rows = parseRows(store.value);
        (rows.length ? rows : [Array(columns).fill('')]).forEach((values) => addRow(values));
        renumber();
    };

    // Inner listener: runs before the calculator's own input listener on the root, so the
    // textarea is current when the tool recalculates.
    body.addEventListener('input', save);

    editor.querySelector('[data-row-add]').addEventListener('click', () => {
        const row = addRow();
        renumber();
        save();
        row.querySelector('input')?.focus();
        store.dispatchEvent(new Event('input', { bubbles: true }));
    });

    body.addEventListener('click', (event) => {
        const button = event.target.closest('[data-row-remove]');

        if (!button) {
            return;
        }

        button.closest('tr').remove();

        if (!body.querySelector('tr')) {
            addRow();
        }

        renumber();
        save();
        store.dispatchEvent(new Event('input', { bubbles: true }));
    });

    store.addEventListener('calc:set', render);
    editor.closest('form')?.addEventListener('reset', () => window.requestAnimationFrame(render));
    render();
}
