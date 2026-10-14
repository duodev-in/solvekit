<x-tool-page-layout
    title="Mbps Calculator - SolveKit"
    description="Professional Mbps calculator for network speeds and data transfer rates. Calculate download times, bandwidth requirements, and network performance with detailed analysis."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Mbps Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Calculation Mode -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Calculation Mode
                                                                                </label>
                                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-green-300 transition-colors cursor-pointer bg-green-50 border-green-300">
                                                                                        <input type="radio" name="mode" value="download-time" class="text-green-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Download Time</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-green-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="speed-test" class="text-green-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Speed Test</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-green-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="bandwidth-calc" class="text-green-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Bandwidth Calc</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Fields Container -->
                                                                            <div id="inputFieldsContainer">

                                                                                <!-- Download Time Mode Fields -->
                                                                                <div id="downloadTimeFields" class="space-y-4">
                                                                                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                                                                                        <div class="space-y-2">
                                                                                            <label for="fileSize" class="block text-sm font-semibold text-gray-700">
                                                                                                File Size
                                                                                            </label>
                                                                                            <div class="grid grid-cols-[minmax(0,1fr)_6.5rem] gap-3">
                                                                                                <input 
                                                                                                    type="number" 
                                                                                                    id="fileSize" 
                                                                                                    class="min-w-0 w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                                    placeholder="100"
                                                                                                    step="any"
                                                                                                >
                                                                                                <select 
                                                                                                    id="fileSizeUnit" 
                                                                                                    class="w-full px-3 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 bg-white font-medium whitespace-nowrap"
                                                                                                >
                                                                                                    <option value="MB">MB</option>
                                                                                                    <option value="GB">GB</option>
                                                                                                    <option value="KB">KB</option>
                                                                                                    <option value="TB">TB</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="space-y-2">
                                                                                            <label for="connectionSpeed" class="block text-sm font-semibold text-gray-700">
                                                                                                Connection Speed
                                                                                            </label>
                                                                                            <div class="grid grid-cols-[minmax(0,1fr)_6.5rem] gap-3">
                                                                                                <input 
                                                                                                    type="number" 
                                                                                                    id="connectionSpeed" 
                                                                                                    class="min-w-0 w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                                    placeholder="100"
                                                                                                    step="any"
                                                                                                >
                                                                                                <select 
                                                                                                    id="speedUnit" 
                                                                                                    class="w-full px-3 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 bg-white font-medium whitespace-nowrap"
                                                                                                >
                                                                                                    <option value="Mbps">Mbps</option>
                                                                                                    <option value="Gbps">Gbps</option>
                                                                                                    <option value="Kbps">Kbps</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Speed Test Mode Fields -->
                                                                                <div id="speedTestFields" class="space-y-4 hidden">
                                                                                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                                                                                        <div class="space-y-2">
                                                                                            <label for="dataTransferred" class="block text-sm font-semibold text-gray-700">
                                                                                                Data Transferred
                                                                                            </label>
                                                                                            <div class="grid grid-cols-[minmax(0,1fr)_6.5rem] gap-3">
                                                                                                <input 
                                                                                                    type="number" 
                                                                                                    id="dataTransferred" 
                                                                                                    class="min-w-0 w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                                    placeholder="500"
                                                                                                    step="any"
                                                                                                >
                                                                                                <select 
                                                                                                    id="dataUnit" 
                                                                                                    class="w-full px-3 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 bg-white font-medium whitespace-nowrap"
                                                                                                >
                                                                                                    <option value="MB">MB</option>
                                                                                                    <option value="GB">GB</option>
                                                                                                    <option value="KB">KB</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="space-y-2">
                                                                                            <label for="transferTime" class="block text-sm font-semibold text-gray-700">
                                                                                                Transfer Time
                                                                                            </label>
                                                                                            <div class="grid grid-cols-[minmax(0,1fr)_6.5rem] gap-3">
                                                                                                <input 
                                                                                                    type="number" 
                                                                                                    id="transferTime" 
                                                                                                    class="min-w-0 w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                                    placeholder="40"
                                                                                                    step="any"
                                                                                                >
                                                                                                <select 
                                                                                                    id="timeUnit" 
                                                                                                    class="w-full px-3 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 bg-white font-medium whitespace-nowrap"
                                                                                                >
                                                                                                    <option value="seconds">Seconds</option>
                                                                                                    <option value="minutes">Minutes</option>
                                                                                                    <option value="hours">Hours</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Bandwidth Calculator Mode Fields -->
                                                                                <div id="bandwidthFields" class="space-y-4 hidden">
                                                                                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                                                                                        <div class="space-y-2">
                                                                                            <label for="users" class="block text-sm font-semibold text-gray-700">
                                                                                                Number of Users
                                                                                            </label>
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="users" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                                placeholder="50"
                                                                                                min="1"
                                                                                            >
                                                                                        </div>

                                                                                        <div class="space-y-2">
                                                                                            <label for="perUserBandwidth" class="block text-sm font-semibold text-gray-700">
                                                                                                Per User Bandwidth
                                                                                            </label>
                                                                                            <div class="grid grid-cols-[minmax(0,1fr)_6.5rem] gap-3">
                                                                                                <input 
                                                                                                    type="number" 
                                                                                                    id="perUserBandwidth" 
                                                                                                    class="min-w-0 w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                                    placeholder="10"
                                                                                                    step="any"
                                                                                                >
                                                                                                <select 
                                                                                                    id="userBandwidthUnit" 
                                                                                                    class="w-full px-3 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 bg-white font-medium whitespace-nowrap"
                                                                                                >
                                                                                                    <option value="Mbps">Mbps</option>
                                                                                                    <option value="Kbps">Kbps</option>
                                                                                                    <option value="Gbps">Gbps</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <!-- Network Efficiency -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Network Efficiency
                                                                                </label>
                                                                                <div class="flex items-center space-x-4">
                                                                                    <input 
                                                                                        type="range" 
                                                                                        id="efficiency" 
                                                                                        min="50" 
                                                                                        max="100" 
                                                                                        value="80" 
                                                                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                                                                    >
                                                                                    <span class="text-sm font-mono text-gray-700 min-w-[3rem]" id="efficiencyValue">80%</span>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Account for network overhead and real-world conditions</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Value</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-l-4 border-green-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Download Time</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Estimated download time</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-green-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-green-600 hover:text-green-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Speed Breakdown -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Theoretical Speed -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Theoretical Speed</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="theoreticalSpeed">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Maximum possible</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Practical Speed -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Practical Speed</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="practicalSpeed">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">With efficiency factor</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const modeRadios = document.getElementsByName('mode');
                        const efficiency = document.getElementById('efficiency');
                        const efficiencyValue = document.getElementById('efficiencyValue');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Input fields for different modes
                        const fileSize = document.getElementById('fileSize');
                        const fileSizeUnit = document.getElementById('fileSizeUnit');
                        const connectionSpeed = document.getElementById('connectionSpeed');
                        const speedUnit = document.getElementById('speedUnit');
                        const dataTransferred = document.getElementById('dataTransferred');
                        const dataUnit = document.getElementById('dataUnit');
                        const transferTime = document.getElementById('transferTime');
                        const timeUnit = document.getElementById('timeUnit');
                        const users = document.getElementById('users');
                        const perUserBandwidth = document.getElementById('perUserBandwidth');
                        const userBandwidthUnit = document.getElementById('userBandwidthUnit');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const theoreticalSpeed = document.getElementById('theoreticalSpeed');
                        const practicalSpeed = document.getElementById('practicalSpeed');
                        const copyResult = document.getElementById('copyResult');

                        // Unit conversion factors to Mbps
                        const speedMultipliers = {
                            'Kbps': 0.001,
                            'Mbps': 1,
                            'Gbps': 1000
                        };

                        // Unit conversion factors to MB
                        const sizeMultipliers = {
                            'KB': 0.001,
                            'MB': 1,
                            'GB': 1000,
                            'TB': 1000000
                        };

                        // Time conversion factors to seconds
                        const timeMultipliers = {
                            'seconds': 1,
                            'minutes': 60,
                            'hours': 3600
                        };

                        const defaultDescriptions = {
                            'download-time': 'Estimated download time',
                            'speed-test': 'Calculated connection speed',
                            'bandwidth-calc': 'Required total bandwidth'
                        };

                        function getMode() {
                            const checked = document.querySelector('input[name="mode"]:checked');
                            return checked ? checked.value : 'download-time';
                        }

                            function formatDecimal(num, fractionDigits = 2) {
                                if (!Number.isFinite(num)) {
                                    return '--';
                                }

                                const abs = Math.abs(num);

                                if (abs === 0) {
                                    return '0';
                                }

                                if (abs >= 1e15 || abs < 1e-6) {
                                    return num.toExponential(4).replace(/\.?0+e/, 'e');
                                }

                                if (abs >= 1) {
                                    return num.toLocaleString('en-US', { maximumFractionDigits: fractionDigits });
                                }

                                return num.toLocaleString('en-US', { maximumSignificantDigits: 3 });
                            }

                            function formatTime(seconds) {
                                if (!Number.isFinite(seconds)) {
                                    return '--';
                                }

                                if (seconds < 60) {
                                    return `${formatDecimal(seconds, 1)} s`;
                                }

                                const totalSeconds = Math.round(seconds);
                                const days = Math.floor(totalSeconds / 86400);
                                const hours = Math.floor((totalSeconds % 86400) / 3600);
                                const minutes = Math.floor((totalSeconds % 3600) / 60);
                                const secs = totalSeconds % 60;

                                if (days > 0) {
                                    return `${days.toLocaleString('en-US')} d ${hours} h`;
                                }

                                if (hours > 0) {
                                    return `${hours} h ${minutes} min`;
                                }

                                return `${minutes} min ${secs} s`;
                            }

                            function formatSpeed(mbps) {
                                if (mbps >= 1000) {
                                    return `${formatDecimal(mbps / 1000)} Gbps`;
                                } else if (mbps >= 1) {
                                    return `${formatDecimal(mbps)} Mbps`;
                                }

                                return `${formatDecimal(mbps * 1000)} Kbps`;
                            }

                            function formatSize(mb) {
                                if (mb >= 1000000) {
                                    return `${formatDecimal(mb / 1000000)} TB`;
                                } else if (mb >= 1000) {
                                    return `${formatDecimal(mb / 1000)} GB`;
                                } else if (mb >= 1) {
                                    return `${formatDecimal(mb)} MB`;
                                }

                                return `${formatDecimal(mb * 1000)} KB`;
                            }

                            function updateModeInterface() {
                                const mode = getMode();

                                // Hide all field groups
                                document.getElementById('downloadTimeFields').classList.add('hidden');
                                document.getElementById('speedTestFields').classList.add('hidden');
                                document.getElementById('bandwidthFields').classList.add('hidden');

                                // Show appropriate fields and update result title
                                switch (mode) {
                                    case 'download-time':
                                        document.getElementById('downloadTimeFields').classList.remove('hidden');
                                        resultTitle.textContent = 'Download Time';
                                        break;
                                    case 'speed-test':
                                        document.getElementById('speedTestFields').classList.remove('hidden');
                                        resultTitle.textContent = 'Connection Speed';
                                        break;
                                    case 'bandwidth-calc':
                                        document.getElementById('bandwidthFields').classList.remove('hidden');
                                        resultTitle.textContent = 'Total Bandwidth';
                                        break;
                                }

                                resultDescription.textContent = defaultDescriptions[mode];
                            }

                        function calculate() {
                            const mode = getMode();
                            const efficiencyPercent = parseInt(efficiency.value);
                            const efficiencyFactor = efficiencyPercent / 100;

                            let result = null;

                            switch (mode) {
                                case 'download-time':
                                    result = calculateDownloadTime(efficiencyFactor);
                                    break;
                                case 'speed-test':
                                    result = calculateSpeed(efficiencyFactor);
                                    break;
                                case 'bandwidth-calc':
                                    result = calculateBandwidth(efficiencyFactor);
                                    break;
                            }

                            if (result) {
                                updateDisplay(result);
                            } else {
                                clearOutputs();
                            }
                        }

                        function calculateDownloadTime(efficiencyFactor) {
                            const size = parseFloat(fileSize.value);
                            const speed = parseFloat(connectionSpeed.value);
                            
                            if (isNaN(size) || isNaN(speed) || size <= 0 || speed <= 0) {
                                return null;
                            }

                            const sizeInMB = size * sizeMultipliers[fileSizeUnit.value];
                            const speedInMbps = speed * speedMultipliers[speedUnit.value];
                            
                            // Convert Mbps to MB/s (divide by 8)
                            const theoreticalSpeedMBps = speedInMbps / 8;
                            const practicalSpeedMBps = theoreticalSpeedMBps * efficiencyFactor;
                            
                            const downloadTimeSeconds = sizeInMB / practicalSpeedMBps;
                            
                            return {
                                type: 'download-time',
                                primaryResult: formatTime(downloadTimeSeconds),
                                sizeInMB: sizeInMB,
                                speedInMbps: speedInMbps,
                                theoreticalSpeedMBps: theoreticalSpeedMBps,
                                practicalSpeedMBps: practicalSpeedMBps,
                                downloadTimeSeconds: downloadTimeSeconds,
                                efficiencyFactor: efficiencyFactor
                            };
                        }

                        function calculateSpeed(efficiencyFactor) {
                            const data = parseFloat(dataTransferred.value);
                            const time = parseFloat(transferTime.value);
                            
                            if (isNaN(data) || isNaN(time) || data <= 0 || time <= 0) {
                                return null;
                            }

                            const dataInMB = data * sizeMultipliers[dataUnit.value];
                            const timeInSeconds = time * timeMultipliers[timeUnit.value];
                            
                            // Calculate actual transfer rate in MB/s
                            const actualSpeedMBps = dataInMB / timeInSeconds;
                            
                            // Convert to Mbps (multiply by 8)
                            const actualSpeedMbps = actualSpeedMBps * 8;
                            
                            // Calculate theoretical speed accounting for efficiency
                            const theoreticalSpeedMbps = actualSpeedMbps / efficiencyFactor;
                            
                            return {
                                type: 'speed-test',
                                primaryResult: formatSpeed(actualSpeedMbps),
                                dataInMB: dataInMB,
                                timeInSeconds: timeInSeconds,
                                actualSpeedMbps: actualSpeedMbps,
                                theoreticalSpeedMbps: theoreticalSpeedMbps,
                                efficiencyFactor: efficiencyFactor
                            };
                        }

                        function calculateBandwidth(efficiencyFactor) {
                            const userCount = parseInt(users.value);
                            const perUser = parseFloat(perUserBandwidth.value);
                            
                            if (isNaN(userCount) || isNaN(perUser) || userCount <= 0 || perUser <= 0) {
                                return null;
                            }

                            const perUserMbps = perUser * speedMultipliers[userBandwidthUnit.value];
                            const totalTheoreticalMbps = userCount * perUserMbps;
                            const totalRequiredMbps = totalTheoreticalMbps / efficiencyFactor;
                            
                            return {
                                type: 'bandwidth-calc',
                                primaryResult: formatSpeed(totalRequiredMbps),
                                userCount: userCount,
                                perUserMbps: perUserMbps,
                                totalTheoreticalMbps: totalTheoreticalMbps,
                                totalRequiredMbps: totalRequiredMbps,
                                efficiencyFactor: efficiencyFactor
                            };
                        }

                        function updateDisplay(result) {
                            const efficiencyPercent = Math.round(result.efficiencyFactor * 100);

                            output.textContent = result.primaryResult;

                            switch (result.type) {
                                case 'download-time':
                                    theoreticalSpeed.textContent = formatSpeed(result.speedInMbps);
                                    practicalSpeed.textContent = formatSpeed(result.speedInMbps * result.efficiencyFactor);
                                    resultDescription.textContent = `${formatSize(result.sizeInMB)} at ${formatSpeed(result.speedInMbps)} (${efficiencyPercent}% efficiency)`;
                                    break;
                                case 'speed-test':
                                    theoreticalSpeed.textContent = formatSpeed(result.theoreticalSpeedMbps);
                                    practicalSpeed.textContent = formatSpeed(result.actualSpeedMbps);
                                    resultDescription.textContent = `${formatSize(result.dataInMB)} transferred in ${formatTime(result.timeInSeconds)}`;
                                    break;
                                case 'bandwidth-calc':
                                    theoreticalSpeed.textContent = formatSpeed(result.totalTheoreticalMbps);
                                    practicalSpeed.textContent = formatSpeed(result.totalRequiredMbps);
                                    resultDescription.textContent = `${result.userCount.toLocaleString('en-US')} users at ${formatSpeed(result.perUserMbps)} each (${efficiencyPercent}% efficiency)`;
                                    break;
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultDescription.textContent = defaultDescriptions[getMode()];
                            theoreticalSpeed.textContent = '--';
                            practicalSpeed.textContent = '--';
                        }

                        function clearAll() {
                            // Clear all input fields
                            fileSize.value = '';
                            connectionSpeed.value = '';
                            dataTransferred.value = '';
                            transferTime.value = '';
                            users.value = '';
                            perUserBandwidth.value = '';
                            
                            // Reset dropdowns
                            fileSizeUnit.value = 'MB';
                            speedUnit.value = 'Mbps';
                            dataUnit.value = 'MB';
                            timeUnit.value = 'seconds';
                            userBandwidthUnit.value = 'Mbps';
                            
                            // Reset efficiency
                            efficiency.value = 80;
                            efficiencyValue.textContent = '80%';
                            
                            // Reset mode
                            document.querySelector('input[value="download-time"]').checked = true;
                            updateModeInterface();
                            
                            clearOutputs();
                        }

                        // Event listeners
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateModeInterface();
                                calculate();
                            });
                        });

                        efficiency.addEventListener('input', function() {
                            efficiencyValue.textContent = this.value + '%';
                            calculate();
                        });

                        // Add event listeners to all input fields
                        [fileSize, connectionSpeed, dataTransferred, transferTime, users, perUserBandwidth].forEach(input => {
                            if (input) {
                                input.addEventListener('input', calculate);
                            }
                        });

                        [fileSizeUnit, speedUnit, dataUnit, timeUnit, userBandwidthUnit].forEach(select => {
                            if (select) {
                                select.addEventListener('change', calculate);
                            }
                        });

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

                        // Initialize
                        updateModeInterface();
                        efficiencyValue.textContent = efficiency.value + '%';
                        
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
