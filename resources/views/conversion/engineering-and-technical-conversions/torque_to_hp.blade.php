<x-tool-page-layout
    title="Torque to HP Calculator - ConvertPro"
    description="Professional torque to horsepower calculator for engineering applications. Calculate power output from torque and RPM values with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Torque to HP</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Torque Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="torqueValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Torque Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="torqueValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter torque value"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="torqueUnitDisplay">ft-lbs</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Torque Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="torqueUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    Torque Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="torqueUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="ftlbs">Foot-pounds (ft-lbs)</option>
                                                                                    <option value="nm">Newton-meters (Nm)</option>
                                                                                    <option value="inchlbs">Inch-pounds (in-lbs)</option>
                                                                                    <option value="kgm">Kilogram-meters (kg⋅m)</option>
                                                                                    <option value="ozin">Ounce-inches (oz-in)</option>
                                                                                    <option value="dyncm">Dyne-centimeters (dyn⋅cm)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- RPM Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="rpmValue" class="block text-sm font-semibold text-gray-700">
                                                                                    RPM (Revolutions per minute)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="rpmValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter RPM"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">RPM</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Power Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="powerUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    Power Output Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="powerUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="hp">Horsepower (HP)</option>
                                                                                    <option value="kw">Kilowatts (kW)</option>
                                                                                    <option value="watts">Watts (W)</option>
                                                                                    <option value="bhp">Brake Horsepower (BHP)</option>
                                                                                    <option value="ps">Metric Horsepower (PS)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Common RPM Presets -->
                                                                            

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-orange-100 hover:bg-orange-200 text-orange-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear All
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Value</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-orange-50 to-red-50 rounded-xl border-l-4 border-orange-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Power Output</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Calculated power from torque and RPM</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-orange-600 font-mono" id="output">--</div>
                                                                                        <div class="text-sm text-gray-500 font-medium" id="powerUnitDisplay">HP</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Calculation Details -->
                                                                            <div class="p-4 bg-gray-50 rounded-lg">
                                                                                <h4 class="text-sm font-semibold text-gray-700 mb-3 text-center">Calculation Details</h4>
                                                                                <div class="space-y-2 text-sm text-gray-600">
                                                                                    <div class="flex justify-between">
                                                                                        <span>Torque (converted to ft-lbs):</span>
                                                                                        <span class="font-mono" id="convertedTorque">--</span>
                                                                                    </div>
                                                                                    <div class="flex justify-between">
                                                                                        <span>RPM:</span>
                                                                                        <span class="font-mono" id="displayRpm">--</span>
                                                                                    </div>
                                                                                    <div class="flex justify-between">
                                                                                        <span>Formula:</span>
                                                                                        <span class="font-mono text-xs">HP = (Torque × RPM) ÷ 5252</span>
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
                <div class="space-y-2">
                                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                                    Common RPM Values
                                                                                                </label>
                                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                                    <button type="button" class="rpm-preset px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-rpm="1800">1800</button>
                                                                                                    <button type="button" class="rpm-preset px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-rpm="3600">3600</button>
                                                                                                    <button type="button" class="rpm-preset px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-rpm="5000">5000</button>
                                                                                                    <button type="button" class="rpm-preset px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-rpm="6000">6000</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Formula Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Power Calculation Formulas</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• HP = (Torque × RPM) ÷ 5252</div>
                                                        <div>• kW = HP × 0.7457</div>
                                                        <div>• 1 HP = 745.7 Watts</div>
                                                        <div>• 1 PS = 0.9863 HP</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Torque to HP Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Power Relationship</h4>
                                    <p>Power is the rate of doing work and is calculated from torque and rotational speed (RPM). The relationship shows how torque and speed combine to produce usable power in rotating machinery.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Engineering Applications</h4>
                                    <p>Essential for motor selection, pump sizing, gear design, engine performance analysis, and any application involving rotating equipment where power requirements must be determined from torque specifications.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-orange-50 rounded-lg border border-orange-200">
                                <p class="text-sm text-orange-800">
                                    <strong>Engineering Note:</strong> The constant 5252 comes from the conversion between foot-pounds, RPM, and horsepower units. Always verify torque and speed units for accurate calculations!
                                </p>
                            </div>
                        </div>

                        <!-- Common Application Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Engineering Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Small Motor</div>
                                    <div class="text-orange-600 cursor-pointer hover:text-orange-800 transition-colors" data-torque="10" data-rpm="1800">10 ft-lbs @ 1800 RPM</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 3.4 HP</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Car Engine</div>
                                    <div class="text-orange-600 cursor-pointer hover:text-orange-800 transition-colors" data-torque="250" data-rpm="5000">250 ft-lbs @ 5000 RPM</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 238 HP</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Industrial Pump</div>
                                    <div class="text-orange-600 cursor-pointer hover:text-orange-800 transition-colors" data-torque="150" data-rpm="3600">150 ft-lbs @ 3600 RPM</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 103 HP</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="font-semibold text-gray-700">Small Tool</div>
                                    <div class="text-orange-600 cursor-pointer hover:text-orange-800 transition-colors" data-torque="2" data-rpm="6000">2 ft-lbs @ 6000 RPM</div>
                                    <div class="text-xs text-gray-500 mt-1">≈ 2.3 HP</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const torqueValue = document.getElementById('torqueValue');
                        const torqueUnit = document.getElementById('torqueUnit');
                        const torqueUnitDisplay = document.getElementById('torqueUnitDisplay');
                        const rpmValue = document.getElementById('rpmValue');
                        const powerUnit = document.getElementById('powerUnit');
                        const powerUnitDisplay = document.getElementById('powerUnitDisplay');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const convertedTorque = document.getElementById('convertedTorque');
                        const displayRpm = document.getElementById('displayRpm');

                        // Torque conversion factors to ft-lbs
                        const torqueConversions = {
                            ftlbs: 1,
                            nm: 0.737562149,
                            inchlbs: 1/12,
                            kgm: 7.23301,
                            ozin: 1/192,
                            dyncm: 7.375621e-8
                        };

                        // Power conversion factors from HP
                        const powerConversions = {
                            hp: 1,
                            kw: 0.745699872,
                            watts: 745.699872,
                            bhp: 1, // Same as HP for calculation purposes
                            ps: 1.01387 // PS (Pferdestärke) conversion
                        };

                        const unitSymbols = {
                            ftlbs: 'ft-lbs',
                            nm: 'Nm',
                            inchlbs: 'in-lbs',
                            kgm: 'kg⋅m',
                            ozin: 'oz-in',
                            dyncm: 'dyn⋅cm',
                            hp: 'HP',
                            kw: 'kW',
                            watts: 'W',
                            bhp: 'BHP',
                            ps: 'PS'
                        };

                        function formatNumber(num) {
                            if (num >= 1000000) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function updateUnitDisplays() {
                            torqueUnitDisplay.textContent = unitSymbols[torqueUnit.value];
                            powerUnitDisplay.textContent = unitSymbols[powerUnit.value];
                            
                            const powerUnitName = {
                                hp: 'Horsepower',
                                kw: 'Kilowatts',
                                watts: 'Watts',
                                bhp: 'Brake Horsepower',
                                ps: 'Metric Horsepower'
                            };
                            
                            resultTitle.textContent = `Power in ${powerUnitName[powerUnit.value]}`;
                            resultDescription.textContent = 'Calculated from torque and RPM';
                        }

                        function convert() {
                            const torque = parseFloat(torqueValue.value);
                            const rpm = parseFloat(rpmValue.value);

                            if (!isNaN(torque) && !isNaN(rpm) && torque > 0 && rpm > 0) {
                                // Convert torque to ft-lbs
                                const torqueInFtLbs = torque * torqueConversions[torqueUnit.value];
                                
                                // Calculate horsepower using the standard formula
                                const hp = (torqueInFtLbs * rpm) / 5252;
                                
                                // Convert to selected power unit
                                const result = hp * powerConversions[powerUnit.value];
                                
                                // Update primary output
                                output.textContent = formatNumber(result);
                                
                                // Update calculation details
                                convertedTorque.textContent = formatNumber(torqueInFtLbs) + ' ft-lbs';
                                displayRpm.textContent = formatNumber(rpm) + ' RPM';
                                
                            } else {
                                output.textContent = '--';
                                convertedTorque.textContent = '--';
                                displayRpm.textContent = '--';
                            }
                        }

                        function clearAll() {
                            torqueValue.value = '';
                            rpmValue.value = '';
                            convert();
                            torqueValue.focus();
                        }

                        // Event listeners
                        torqueValue.addEventListener('input', convert);
                        torqueUnit.addEventListener('change', () => {
                            updateUnitDisplays();
                            convert();
                        });
                        rpmValue.addEventListener('input', convert);
                        powerUnit.addEventListener('change', () => {
                            updateUnitDisplays();
                            convert();
                        });
                        clearButton.addEventListener('click', clearAll);

                        // RPM preset buttons
                        const rpmPresets = document.querySelectorAll('.rpm-preset');
                        rpmPresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const rpm = this.getAttribute('data-rpm');
                                
                                rpmValue.value = rpm;
                                convert();
                                
                                // Update button styles
                                rpmPresets.forEach(btn => btn.classList.remove('bg-orange-100', 'text-orange-700'));
                                rpmPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-orange-100', 'text-orange-700');
                            });
                        });

                        // Add clickable functionality to examples
                        const examples = document.querySelectorAll('[data-torque][data-rpm]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const torque = this.getAttribute('data-torque');
                                const rpm = this.getAttribute('data-rpm');
                                
                                torqueUnit.value = 'ftlbs'; // Examples are in ft-lbs
                                torqueValue.value = torque;
                                rpmValue.value = rpm;
                                updateUnitDisplays();
                                convert();
                                torqueValue.focus();
                            });
                        });

                        // Initialize
                        torqueValue.focus();
                        updateUnitDisplays();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
