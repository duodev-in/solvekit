<x-tool-page-layout
    title="CPS Calculator - ConvertPro"
    description="Professional CPS calculator for cycles per second calculations. Convert frequency units, analyze periodic signals, and calculate timing parameters for engineering applications."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">CPS Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Calculation Method -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Calculation Method
                                                                                </label>
                                                                                <select 
                                                                                    id="calculationMethod" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="frequency_input" selected>Frequency Input (Hz/CPS)</option>
                                                                                    <option value="period_input">Period Input (seconds)</option>
                                                                                    <option value="rpm_input">RPM Input (revolutions/min)</option>
                                                                                    <option value="wavelength_input">Wavelength Input</option>
                                                                                    <option value="event_counting">Event Counting</option>
                                                                                    <option value="duty_cycle">Duty Cycle Analysis</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Primary Input -->
                                                                            <div class="space-y-2" id="primaryInputContainer">
                                                                                <label for="primaryValue" class="block text-sm font-semibold text-gray-700" id="primaryLabel">
                                                                                    Frequency (Hz)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="primaryValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter frequency (e.g., 60)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="primaryUnit">Hz</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="primaryHint">Enter frequency value in hertz</p>
                                                                            </div>

                                                                            <!-- Secondary Input (for specific methods) -->
                                                                            <div class="space-y-2" id="secondaryInputContainer" style="display: none;">
                                                                                <label for="secondaryValue" class="block text-sm font-semibold text-gray-700" id="secondaryLabel">
                                                                                    Additional Parameter
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="secondaryValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter value"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="secondaryUnit">unit</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="secondaryHint">Enter additional parameter</p>
                                                                            </div>

                                                                            <!-- Wave Properties (for wavelength) -->
                                                                            <div class="space-y-2" id="wavePropertiesContainer" style="display: none;">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Wave Type
                                                                                </label>
                                                                                <select 
                                                                                    id="waveType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="sound_air" selected>Sound in Air (343 m/s)</option>
                                                                                    <option value="sound_water">Sound in Water (1500 m/s)</option>
                                                                                    <option value="electromagnetic">Electromagnetic (3×10⁸ m/s)</option>
                                                                                    <option value="seismic">Seismic Waves (6000 m/s)</option>
                                                                                    <option value="custom">Custom Wave Speed</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Custom Wave Speed -->
                                                                            <div class="space-y-2" id="customSpeedContainer" style="display: none;">
                                                                                <label for="customSpeed" class="block text-sm font-semibold text-gray-700">
                                                                                    Wave Speed
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="customSpeed" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter wave speed"
                                                                                        step="any"
                                                                                        min="0"
                                                                                        value="343"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">m/s</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Wave propagation speed in medium</p>
                                                                            </div>




                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Frequency Analysis Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl border-l-4 border-pink-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Cycles Per Second (CPS)</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Enter a value to calculate the frequency</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-pink-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-pink-600 hover:text-pink-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Frequency Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Basic Frequency Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Frequency Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Hertz (Hz)</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="hertzDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Cycles per second</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Kilohertz (kHz)</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="kilohertzDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1000 Hz</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Megahertz (MHz)</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="megahertzDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1,000,000 Hz</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Time Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Time Parameters</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Period</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="periodDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Time per cycle</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Angular Frequency</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="angularFreqDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Radians per second</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">RPM</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="rpmDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Revolutions per minute</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Wave Properties -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Wave Properties</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Wavelength</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="wavelengthDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Distance per cycle</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Wave Number</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="waveNumberDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Cycles per meter</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Wave Speed</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="waveSpeedDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Propagation velocity</div>
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
                <!-- Quick CPS Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Frequency Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-700 rounded-lg transition-colors" data-value="60" data-method="frequency_input">60 Hz</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-700 rounded-lg transition-colors" data-value="1000" data-method="frequency_input">1 kHz</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-700 rounded-lg transition-colors" data-value="0.0167" data-method="period_input">1 min</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-gray-700 hover:text-pink-700 rounded-lg transition-colors" data-value="3600" data-method="rpm_input">3600 RPM</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Frequency Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Hz</strong> = 1 cycle/second</div>
                                                        <div><strong>1 kHz</strong> = 1,000 Hz</div>
                                                        <div><strong>1 MHz</strong> = 1,000,000 Hz</div>
                                                        <div><strong>1 GHz</strong> = 1,000,000,000 Hz</div>
                                                        <div><strong>Power line</strong> = 50/60 Hz</div>
                                                        <div><strong>Audio range</strong> = 20 Hz - 20 kHz</div>
                                                        <div><strong>AM radio</strong> = 0.5-1.6 MHz</div>
                                                        <div><strong>FM radio</strong> = 88-108 MHz</div>
                                                        <div><strong>WiFi 2.4G</strong> = 2.4 GHz</div>
                                                        <div><strong>Microwave</strong> = 2.45 GHz</div>
                                                        <div><strong>Visible light</strong> = 400-700 THz</div>
                                                        <div><strong>CPU clock</strong> = 1-5 GHz</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const calculationMethod = document.getElementById('calculationMethod');
                        const primaryValue = document.getElementById('primaryValue');
                        const secondaryValue = document.getElementById('secondaryValue');
                        const waveType = document.getElementById('waveType');
                        const customSpeed = document.getElementById('customSpeed');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Container elements
                        const secondaryInputContainer = document.getElementById('secondaryInputContainer');
                        const wavePropertiesContainer = document.getElementById('wavePropertiesContainer');
                        const customSpeedContainer = document.getElementById('customSpeedContainer');
                        const primaryLabel = document.getElementById('primaryLabel');
                        const secondaryLabel = document.getElementById('secondaryLabel');
                        const primaryUnit = document.getElementById('primaryUnit');
                        const secondaryUnit = document.getElementById('secondaryUnit');
                        const primaryHint = document.getElementById('primaryHint');
                        const secondaryHint = document.getElementById('secondaryHint');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const hertzDisplay = document.getElementById('hertzDisplay');
                        const kilohertzDisplay = document.getElementById('kilohertzDisplay');
                        const megahertzDisplay = document.getElementById('megahertzDisplay');
                        const periodDisplay = document.getElementById('periodDisplay');
                        const angularFreqDisplay = document.getElementById('angularFreqDisplay');
                        const rpmDisplay = document.getElementById('rpmDisplay');
                        const wavelengthDisplay = document.getElementById('wavelengthDisplay');
                        const waveNumberDisplay = document.getElementById('waveNumberDisplay');
                        const waveSpeedDisplay = document.getElementById('waveSpeedDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Wave speeds (m/s)
                        const waveSpeeds = {
                            sound_air: 343,
                            sound_water: 1500,
                            electromagnetic: 299792458,
                            seismic: 6000,
                            custom: 343
                        };

                        function formatNumber(num, decimals = 6) {
                            if (!Number.isFinite(num)) {
                                return '--';
                            }

                            const abs = Math.abs(num);

                            if (abs === 0) {
                                return '0';
                            }

                            if (abs >= 1e12 || abs < 1e-6) {
                                return num.toExponential(4).replace(/\.?0+e/, 'e');
                            }

                            if (abs >= 1) {
                                return num.toLocaleString('en-US', { maximumFractionDigits: decimals });
                            }

                            return num.toLocaleString('en-US', { maximumSignificantDigits: 6 });
                        }

                        function updateInputLabels() {
                            const method = calculationMethod.value;
                            
                            secondaryInputContainer.style.display = 'none';
                            wavePropertiesContainer.style.display = 'none';
                            customSpeedContainer.style.display = 'none';
                            
                            switch(method) {
                                case 'frequency_input':
                                    primaryLabel.textContent = 'Frequency (Hz)';
                                    primaryUnit.textContent = 'Hz';
                                    primaryHint.textContent = 'Enter frequency value in hertz';
                                    break;
                                case 'period_input':
                                    primaryLabel.textContent = 'Period';
                                    primaryUnit.textContent = 's';
                                    primaryHint.textContent = 'Enter period in seconds';
                                    break;
                                case 'rpm_input':
                                    primaryLabel.textContent = 'RPM';
                                    primaryUnit.textContent = 'RPM';
                                    primaryHint.textContent = 'Enter revolutions per minute';
                                    break;
                                case 'wavelength_input':
                                    primaryLabel.textContent = 'Wavelength';
                                    primaryUnit.textContent = 'm';
                                    primaryHint.textContent = 'Enter wavelength in meters';
                                    wavePropertiesContainer.style.display = 'block';
                                    updateCustomSpeedVisibility();
                                    break;
                                case 'event_counting':
                                    primaryLabel.textContent = 'Event Count';
                                    primaryUnit.textContent = 'events';
                                    primaryHint.textContent = 'Enter number of events';
                                    secondaryInputContainer.style.display = 'block';
                                    secondaryLabel.textContent = 'Time Duration';
                                    secondaryUnit.textContent = 's';
                                    secondaryHint.textContent = 'Enter time duration in seconds';
                                    break;
                                case 'duty_cycle':
                                    primaryLabel.textContent = 'Frequency (Hz)';
                                    primaryUnit.textContent = 'Hz';
                                    primaryHint.textContent = 'Enter base frequency';
                                    secondaryInputContainer.style.display = 'block';
                                    secondaryLabel.textContent = 'Duty Cycle';
                                    secondaryUnit.textContent = '%';
                                    secondaryHint.textContent = 'Enter duty cycle percentage';
                                    break;
                            }
                        }

                        function updateCustomSpeedVisibility() {
                            const type = waveType.value;
                            customSpeedContainer.style.display = type === 'custom' ? 'block' : 'none';
                        }

                        function getWaveSpeed() {
                            const type = waveType.value;
                            if (type === 'custom') {
                                return parseFloat(customSpeed.value) || 343;
                            }
                            return waveSpeeds[type] || 343;
                        }

                        function describeInput(method, primary, secondary) {
                            switch (method) {
                                case 'period_input':
                                    return `Period of ${formatNumber(primary)} s`;
                                case 'rpm_input':
                                    return `${formatNumber(primary)} RPM`;
                                case 'wavelength_input':
                                    return `Wavelength of ${formatNumber(primary)} m`;
                                case 'event_counting':
                                    return `${formatNumber(primary)} events in ${formatNumber(secondary)} s`;
                                default:
                                    return `${formatNumber(primary)} Hz`;
                            }
                        }

                        function calculate() {
                            const method = calculationMethod.value;
                            const primary = parseFloat(primaryValue.value);
                            const secondary = parseFloat(secondaryValue.value);
                            
                            if (!isNaN(primary) && primary > 0) {
                                let frequency = 0;
                                
                                switch(method) {
                                    case 'frequency_input':
                                        frequency = primary;
                                        break;
                                    case 'period_input':
                                        frequency = 1 / primary;
                                        break;
                                    case 'rpm_input':
                                        frequency = primary / 60;
                                        break;
                                    case 'wavelength_input':
                                        const waveSpeed = getWaveSpeed();
                                        frequency = waveSpeed / primary;
                                        break;
                                    case 'event_counting':
                                        if (!isNaN(secondary) && secondary > 0) {
                                            frequency = primary / secondary;
                                        }
                                        break;
                                    case 'duty_cycle':
                                        frequency = primary;
                                        break;
                                }
                                
                                if (frequency > 0) {
                                    // Update primary output
                                    output.textContent = formatNumber(frequency) + ' Hz';
                                    resultTitle.textContent = 'Cycles Per Second (CPS)';
                                    resultDescription.textContent = `${describeInput(method, primary, secondary)} = ${formatNumber(frequency)} cycles per second`;

                                    // Display frequency units
                                    hertzDisplay.textContent = formatNumber(frequency) + ' Hz';
                                    kilohertzDisplay.textContent = formatNumber(frequency / 1000) + ' kHz';
                                    megahertzDisplay.textContent = formatNumber(frequency / 1000000) + ' MHz';

                                    // Display time parameters
                                    const period = 1 / frequency;
                                    periodDisplay.textContent = formatNumber(period) + ' s';
                                    const angularFreq = 2 * Math.PI * frequency;
                                    angularFreqDisplay.textContent = formatNumber(angularFreq) + ' rad/s';
                                    const rpm = frequency * 60;
                                    rpmDisplay.textContent = formatNumber(rpm) + ' RPM';

                                    // Display wave properties
                                    const currentWaveSpeed = getWaveSpeed();
                                    const wavelength = currentWaveSpeed / frequency;
                                    wavelengthDisplay.textContent = formatNumber(wavelength) + ' m';
                                    const waveNumber = 1 / wavelength;
                                    waveNumberDisplay.textContent = formatNumber(waveNumber) + ' m⁻¹';
                                    waveSpeedDisplay.textContent = formatNumber(currentWaveSpeed) + ' m/s';

                                } else {
                                    clearOutputs();
                                }
                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Cycles Per Second (CPS)';
                            resultDescription.textContent = 'Enter a value to calculate the frequency';
                            hertzDisplay.textContent = '--';
                            kilohertzDisplay.textContent = '--';
                            megahertzDisplay.textContent = '--';
                            periodDisplay.textContent = '--';
                            angularFreqDisplay.textContent = '--';
                            rpmDisplay.textContent = '--';
                            wavelengthDisplay.textContent = '--';
                            waveNumberDisplay.textContent = '--';
                            waveSpeedDisplay.textContent = '--';
                        }

                        function clearAll() {
                            primaryValue.value = '';
                            secondaryValue.value = '';
                            calculationMethod.value = 'frequency_input';
                            waveType.value = 'sound_air';
                            customSpeed.value = '343';
                            updateInputLabels();
                            clearOutputs();
                            primaryValue.focus();
                        }

                        // Event listeners
                        calculationMethod.addEventListener('change', function() {
                            updateInputLabels();
                            calculate();
                        });
                        
                        primaryValue.addEventListener('input', calculate);
                        secondaryValue.addEventListener('input', calculate);
                        waveType.addEventListener('change', function() {
                            updateCustomSpeedVisibility();
                            calculate();
                        });
                        customSpeed.addEventListener('input', calculate);

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        // Example buttons
                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const method = this.getAttribute('data-method');
                                
                                calculationMethod.value = method;
                                primaryValue.value = value;
                                updateInputLabels();
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-pink-100', 'text-pink-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-pink-100', 'text-pink-700');
                            });
                        });

                        // Clickable examples
                        const examples = document.querySelectorAll('[data-value][data-method]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const method = this.getAttribute('data-method');
                                
                                if (value && method) {
                                    calculationMethod.value = method;
                                    primaryValue.value = value;
                                    updateInputLabels();
                                    calculate();
                                    primaryValue.focus();
                                }
                            });
                        });

                        // Initialize
                        updateInputLabels();
                        primaryValue.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
