import { bootCalculatorPage } from './core.js';

// Engines are shared calculators (unit tables, number scales…); tools are one-off formula modules.
// Each is split into its own chunk and only the one a page names is downloaded.
const modules = {
    ...import.meta.glob('./engines/*.js'),
    ...import.meta.glob('./tools/*.js'),
};

const loadModule = (name) => {
    const loader = modules[`./engines/${name}.js`] ?? modules[`./tools/${name}.js`];

    return loader ? loader() : Promise.resolve(null);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => bootCalculatorPage(loadModule));
} else {
    bootCalculatorPage(loadModule);
}
