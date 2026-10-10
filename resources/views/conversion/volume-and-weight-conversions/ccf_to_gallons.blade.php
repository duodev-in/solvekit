<x-tool-page-layout
    title="CCF to Gallons Converter - ConvertPro"
    description="Professional CCF to gallons converter for water utility billing. Convert hundred cubic feet to gallons with accurate water volume calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">CCF to Gallons</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="ccf" class="block text-sm font-semibold text-slate-700">
                                                                                    Enter CCF (Hundred Cubic Feet)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="ccf" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter CCF (e.g., 5)"
                                                                                        step="0.01"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">CCF</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">1 CCF = 100 cubic feet</p>
                                                                            </div>

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

                                                                            <!-- Primary Result - Gallons -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">US Gallons</h4>
                                                                                        <p class="text-[11px] text-slate-500">Standard water measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="gallonsOutput">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">gallons</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Liters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="litersOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Cubic Meters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="cubicMetersOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">CCF Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 CCF = 748.052 gallons</div>
                                                        <div>• 1 CCF = 2,831.685 liters</div>
                                                        <div>• 1 CCF = 2.832 cubic meters</div>
                                                        <div>• 1 CCF = 100 cubic feet</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About CCF to Gallons Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is CCF?</h4>
                                    <p>CCF stands for "Centum Cubic Feet" or "Hundred Cubic Feet" (100 ft³). It's a unit commonly used by water utilities for billing purposes, representing a significant volume of water usage.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Water Billing Applications</h4>
                                    <p>Essential for understanding water bills, calculating usage costs, monitoring consumption, and converting between utility measurements and everyday volume units.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Utility Tip:</strong> Average household uses 7-10 CCF per month, which equals about 5,200-7,500 gallons!
                                </p>
                            </div>
                        </div>

                        <!-- Common CCF Usage Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Water Usage in CCF</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">1 Person/Month</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-ccf="2">2 CCF</div>
                                    <div class="text-[11px] text-slate-500">~1,500 gallons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Family/Month</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-ccf="8">8 CCF</div>
                                    <div class="text-[11px] text-slate-500">~6,000 gallons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Swimming Pool</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-ccf="25">25 CCF</div>
                                    <div class="text-[11px] text-slate-500">~18,700 gallons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Large Usage</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-ccf="50">50 CCF</div>
                                    <div class="text-[11px] text-slate-500">~37,400 gallons</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ccfInput = document.getElementById('ccf');
                        const clearButton = document.getElementById('clearButton');
                        const gallonsOutput = document.getElementById('gallonsOutput');
                        const litersOutput = document.getElementById('litersOutput');
                        const cubicMetersOutput = document.getElementById('cubicMetersOutput');

                        // Conversion constants
                        const CCF_TO_GALLONS = 748.051947;
                        const CCF_TO_LITERS = 2831.6846592;
                        const CCF_TO_CUBIC_METERS = 2.8316846592;

                        function formatNumber(num, decimals = 3) {
                            if (num >= 1000000) {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else if (Math.abs(num) < 1) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            } else {
                                return num.toLocaleString(undefined, { maximumFractionDigits: decimals });
                            }
                        }

                        function convert() {
                            const ccf = parseFloat(ccfInput.value);

                            if (!isNaN(ccf) && ccf >= 0) {
                                const gallons = ccf * CCF_TO_GALLONS;
                                const liters = ccf * CCF_TO_LITERS;
                                const cubicMeters = ccf * CCF_TO_CUBIC_METERS;

                                gallonsOutput.textContent = formatNumber(gallons, 2);
                                litersOutput.textContent = formatNumber(liters, 1) + ' L';
                                cubicMetersOutput.textContent = formatNumber(cubicMeters, 3) + ' m³';
                            } else {
                                gallonsOutput.textContent = "--";
                                litersOutput.textContent = "--";
                                cubicMetersOutput.textContent = "--";
                            }
                        }

                        function clearInput() {
                            ccfInput.value = '';
                            convert();
                            ccfInput.focus();
                        }

                        // Event listeners
                        ccfInput.addEventListener('input', convert);
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example CCF values
                        const exampleCCFs = document.querySelectorAll('[data-ccf]');
                        exampleCCFs.forEach(element => {
                            element.addEventListener('click', function() {
                                const ccfValue = this.getAttribute('data-ccf');
                                ccfInput.value = ccfValue;
                                convert();
                                ccfInput.focus();
                            });
                        });

                        // Initialize
                        ccfInput.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
