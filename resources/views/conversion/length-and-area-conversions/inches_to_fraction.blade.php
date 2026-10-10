<x-tool-page-layout
    title="Inches to Fraction Calculator - ConvertPro"
    description="Professional inches to fraction calculator to convert decimal inches to fractions, millimeters, and centimeters. Perfect for woodworking and construction measurements."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Inches to Fraction</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="decimal" class="block text-xs font-semibold text-slate-700">
                                                                                    Enter Decimal Inches
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="decimal" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter decimal (e.g., 2.75)"
                                                                                        step="0.001"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium">inches</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">Common range: 0.001 to 100 inches</p>
                                                                            </div>

                                                                            <!-- Precision Selector -->
                                                                            <div class="space-y-2">
                                                                                <label for="precision" class="block text-xs font-semibold text-slate-700">
                                                                                    Fraction Precision
                                                                                </label>
                                                                                <select 
                                                                                    id="precision" 
                                                                                    class="w-full rounded-md border border-slate-300 bg-white"
                                                                                >
                                                                                    <option value="64">64ths (1/64)</option>
                                                                                    <option value="32">32nds (1/32)</option>
                                                                                    <option value="16" selected>16ths (1/16)</option>
                                                                                    <option value="8">8ths (1/8)</option>
                                                                                    <option value="4">4ths (1/4)</option>
                                                                                    <option value="2">Halves (1/2)</option>
                                                                                </select>
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

                                                                            <!-- Fraction -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Fraction</h4>
                                                                                        <p class="text-[11px] text-slate-500">Imperial fraction format</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="fraction">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">inches</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Millimeters -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Millimeters</h4>
                                                                                        <p class="text-[11px] text-slate-500">Precise metric measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="millimeters">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">mm</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Centimeters -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Centimeters</h4>
                                                                                        <p class="text-[11px] text-slate-500">Common metric unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="centimeters">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">cm</div>
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
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Inches to Fraction Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Essential for woodworking, construction, machining, and crafting where precise fractional measurements are needed. Converts digital caliper readings to traditional ruler markings.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Precision Levels</h4>
                                    <p>Different trades use different precision levels - carpenters often use 16ths, machinists use 64ths, and general construction uses 8ths or 4ths for most applications.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Pro Tip:</strong> For woodworking, 16ths are usually precise enough, while machining often requires 32nds or 64ths!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1/4" = 0.25"</div>
                                <div>• 1/2" = 0.5"</div>
                                <div>• 3/4" = 0.75"</div>
                                <div>• 1" = 25.4 mm</div>
                            </div>
                        </div>

                        <!-- Common Measurements Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Decimal to Fraction Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Quarter Inch</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-decimal="0.25">0.25"</div>
                                    <div class="text-[11px] text-slate-500">1/4"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Three Eighths</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-decimal="0.375">0.375"</div>
                                    <div class="text-[11px] text-slate-500">3/8"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Five Eighths</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-decimal="0.625">0.625"</div>
                                    <div class="text-[11px] text-slate-500">5/8"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Three Quarters</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-decimal="0.75">0.75"</div>
                                    <div class="text-[11px] text-slate-500">3/4"</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const decimalInput = document.getElementById('decimal');
                        const precisionSelect = document.getElementById('precision');
                        const clearButton = document.getElementById('clearButton');
                        const fractionOutput = document.getElementById('fraction');
                        const millimetersOutput = document.getElementById('millimeters');
                        const centimetersOutput = document.getElementById('centimeters');

                        function gcd(a, b) {
                            return b ? gcd(b, a % b) : a;
                        }

                        function nearestFraction(decimal, maxDenominator = 16) {
                            const whole = Math.floor(decimal);
                            const frac = decimal - whole;

                            if (frac === 0) {
                                return whole === 0 ? '0"' : `${whole}"`;
                            }

                            let bestNumerator = 1;
                            let bestDenominator = maxDenominator;
                            let minError = Math.abs(frac - bestNumerator / bestDenominator);

                            for (let denominator = 2; denominator <= maxDenominator; denominator++) {
                                const numerator = Math.round(frac * denominator);
                                const error = Math.abs(frac - numerator / denominator);
                                
                                if (error < minError) {
                                    minError = error;
                                    bestNumerator = numerator;
                                    bestDenominator = denominator;
                                }
                            }

                            // Simplify the fraction
                            const common = gcd(bestNumerator, bestDenominator);
                            const simplifiedNum = bestNumerator / common;
                            const simplifiedDen = bestDenominator / common;

                            // Handle edge cases
                            if (simplifiedNum === 0) {
                                return whole === 0 ? '0"' : `${whole}"`;
                            }
                            if (simplifiedNum === simplifiedDen) {
                                return `${whole + 1}"`;
                            }

                            // Format output
                            if (whole === 0) {
                                return `${simplifiedNum}/${simplifiedDen}"`;
                            } else {
                                return `${whole} ${simplifiedNum}/${simplifiedDen}"`;
                            }
                        }

                        function formatMeasurement(value, fractionDigits) {
                            if (value !== 0 && Math.abs(value) < 0.000001) {
                                return Number(value.toPrecision(4)).toExponential();
                            } else if (Math.abs(value) < 1) {
                                return value.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }

                            return value.toLocaleString(undefined, { maximumFractionDigits: fractionDigits });
                        }

                        function convert() {
                            const inches = parseFloat(decimalInput.value);
                            const precision = parseInt(precisionSelect.value);
                            
                            if (!isNaN(inches) && inches >= 0) {
                                // Calculate conversions
                                const mm = inches * 25.4;
                                const cm = mm / 10;

                                // Display results
                                fractionOutput.textContent = nearestFraction(inches, precision);
                                millimetersOutput.textContent = formatMeasurement(mm, 2);
                                centimetersOutput.textContent = formatMeasurement(cm, 3);
                            } else {
                                // Clear results
                                fractionOutput.textContent = "--";
                                millimetersOutput.textContent = "--";
                                centimetersOutput.textContent = "--";
                            }
                        }

                        function clearInput() {
                            decimalInput.value = '';
                            convert();
                            decimalInput.focus();
                        }

                        // Event listeners
                        decimalInput.addEventListener('input', convert);
                        precisionSelect.addEventListener('change', convert);
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example measurements
                        const exampleMeasurements = document.querySelectorAll('[data-decimal]');
                        exampleMeasurements.forEach(element => {
                            element.addEventListener('click', function() {
                                const decimalValue = this.getAttribute('data-decimal');
                                decimalInput.value = decimalValue;
                                convert();
                                decimalInput.focus();
                            });
                        });

                        // Initialize
                        decimalInput.focus();

                        // Add keyboard shortcuts
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
