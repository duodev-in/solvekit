<x-tool-page-layout
    title="Pixels to Inches Converter - ConvertPro"
    description="Professional pixels to inches converter for digital design and printing. Convert pixels to inches using DPI/PPI settings for accurate print sizing."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Pixels to Inches</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Pixels Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="pixels" class="block text-xs font-semibold text-slate-700">
                                                                                    Pixels
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="pixels" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter pixels (e.g., 1920)"
                                                                                        step="1"
                                                                                        min="1"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium">px</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- DPI Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="dpi" class="block text-xs font-semibold text-slate-700">
                                                                                    DPI (Dots Per Inch)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="dpi" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter DPI (e.g., 300)"
                                                                                        step="1"
                                                                                        min="1"
                                                                                        value="300"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium">dpi</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">Common: 72 (web), 150 (draft), 300 (print)</p>
                                                                            </div>

                                                                            <!-- DPI Presets -->
                                                                            

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + Shift + C to clear</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Physical Size</h4>
                                                                                        <p class="text-[11px] text-slate-500">Print dimensions</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">inches</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Conversions -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Centimeters</h4>
                                                                                        <p class="text-[11px] text-slate-500">Metric equivalent</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="cmOutput">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">cm</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Millimeters</h4>
                                                                                        <p class="text-[11px] text-slate-500">Detailed metric unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="mmOutput">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">mm</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Pixels to Inches Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Digital vs Print Design</h4>
                                    <p>Converting pixels to inches is essential when preparing digital designs for print. The DPI (dots per inch) setting determines how many pixels fit into one physical inch, affecting the final print size and quality.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Applications</h4>
                                    <p>Used in graphic design, web-to-print workflows, photography, publishing, and any situation where digital content needs to be printed at specific physical dimensions.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Designer Tip:</strong> Higher DPI means smaller print size but better quality. 300 DPI is the standard for professional printing!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Common DPI Presets</h3>
                            <div class="grid grid-cols-4 gap-2">
                                <button type="button" class="dpi-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-slate-700 hover:text-indigo-700 rounded-md transition-colors" data-dpi="72">72 DPI</button>
                                <button type="button" class="dpi-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-slate-700 hover:text-indigo-700 rounded-md transition-colors" data-dpi="150">150 DPI</button>
                                <button type="button" class="dpi-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-slate-700 hover:text-indigo-700 rounded-md transition-colors" data-dpi="300">300 DPI</button>
                                <button type="button" class="dpi-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-slate-700 hover:text-indigo-700 rounded-md transition-colors" data-dpi="600">600 DPI</button>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">DPI Reference Guide</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 72 DPI: Web/Screen display</div>
                                <div>• 150 DPI: Draft printing</div>
                                <div>• 300 DPI: High-quality printing</div>
                                <div>• 600 DPI: Professional printing</div>
                            </div>
                        </div>

                        <!-- Common Screen Sizes Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Screen Resolutions</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">HD Width</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-pixels="1920">1920 px</div>
                                    <div class="text-[11px] text-slate-500">Full HD</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">4K Width</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-pixels="3840">3840 px</div>
                                    <div class="text-[11px] text-slate-500">Ultra HD</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">A4 Width</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-pixels="2480">2480 px</div>
                                    <div class="text-[11px] text-slate-500">@ 300 DPI</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Letter Width</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-pixels="2550">2550 px</div>
                                    <div class="text-[11px] text-slate-500">@ 300 DPI</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const pixelsInput = document.getElementById('pixels');
                        const dpiInput = document.getElementById('dpi');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const cmOutput = document.getElementById('cmOutput');
                        const mmOutput = document.getElementById('mmOutput');

                        function formatMeasurement(value, fractionDigits) {
                            if (value !== 0 && Math.abs(value) < 0.000001) {
                                return Number(value.toPrecision(4)).toExponential();
                            } else if (Math.abs(value) < 1) {
                                return value.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }

                            return value.toLocaleString(undefined, { maximumFractionDigits: fractionDigits });
                        }

                        function convert() {
                            const pixels = parseFloat(pixelsInput.value);
                            const dpi = parseFloat(dpiInput.value);

                            if (!isNaN(pixels) && !isNaN(dpi) && pixels > 0 && dpi > 0) {
                                const inches = pixels / dpi;
                                const cm = inches * 2.54;
                                const mm = cm * 10;

                                output.textContent = formatMeasurement(inches, 4);
                                cmOutput.textContent = formatMeasurement(cm, 2) + ' cm';
                                mmOutput.textContent = formatMeasurement(mm, 1) + ' mm';
                            } else {
                                output.textContent = "--";
                                cmOutput.textContent = "--";
                                mmOutput.textContent = "--";
                            }
                        }

                        function clearInputs() {
                            pixelsInput.value = '';
                            dpiInput.value = '300';
                            convert();
                            pixelsInput.focus();
                        }

                        // Event listeners
                        pixelsInput.addEventListener('input', convert);
                        dpiInput.addEventListener('input', convert);
                        clearButton.addEventListener('click', clearInputs);

                        // DPI preset buttons
                        const dpiPresets = document.querySelectorAll('.dpi-preset');
                        dpiPresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const dpiValue = this.getAttribute('data-dpi');
                                dpiInput.value = dpiValue;
                                convert();
                                
                                // Update button styles
                                dpiPresets.forEach(btn => btn.classList.remove('bg-indigo-100', 'text-indigo-700'));
                                dpiPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-slate-700'));
                                this.classList.remove('bg-gray-100', 'text-slate-700');
                                this.classList.add('bg-indigo-100', 'text-indigo-700');
                            });
                        });

                        // Add clickable functionality to example pixels
                        const examplePixels = document.querySelectorAll('[data-pixels]');
                        examplePixels.forEach(element => {
                            element.addEventListener('click', function() {
                                const pixelValue = this.getAttribute('data-pixels');
                                pixelsInput.value = pixelValue;
                                convert();
                                pixelsInput.focus();
                            });
                        });

                        // Initialize
                        pixelsInput.focus();

                        // Add keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInputs();
                            }
                        });

                        // Input validation
                        pixelsInput.addEventListener('input', function() {
                            if (this.value < 0) this.value = '';
                        });
                        
                        dpiInput.addEventListener('input', function() {
                            if (this.value < 0) this.value = '';
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
