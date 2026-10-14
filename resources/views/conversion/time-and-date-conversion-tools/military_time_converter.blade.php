<x-tool-page-layout
    title="Military Time Converter - SolveKit"
    description="Professional military time converter for 12-hour and 24-hour time formats. Convert between standard time and military time with detailed explanations and examples."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Military Time Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                <!-- Current Time Display -->
                                <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Current Time</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600 block">12-Hour Format:</span>
                                            <span class="font-mono text-blue-700 text-lg" id="current12Hour">--</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 block">24-Hour Format:</span>
                                            <span class="font-mono text-blue-700 text-lg" id="current24Hour">--</span>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Mode -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Mode
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer bg-emerald-50 border-emerald-300">
                                                                                        <input type="radio" name="mode" value="12-to-24" class="text-emerald-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">12-Hour → 24-Hour</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="24-to-12" class="text-emerald-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">24-Hour → 12-Hour</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Container -->
                                                                            <div id="inputContainer">

                                                                                <!-- 12-Hour Input -->
                                                                                <div id="input12Hour" class="space-y-4">
                                                                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                                                                        <div class="space-y-2">
                                                                                            <label for="hour12" class="block text-sm font-semibold text-gray-700">
                                                                                                Hour (1-12)
                                                                                            </label>
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="hour12" 
                                                                                                min="1" 
                                                                                                max="12" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono text-center" 
                                                                                                placeholder="12"
                                                                                            >
                                                                                        </div>

                                                                                        <div class="space-y-2">
                                                                                            <label for="minute12" class="block text-sm font-semibold text-gray-700">
                                                                                                Minute (0-59)
                                                                                            </label>
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="minute12" 
                                                                                                min="0" 
                                                                                                max="59" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono text-center" 
                                                                                                placeholder="00"
                                                                                            >
                                                                                        </div>

                                                                                        <div class="space-y-2">
                                                                                            <label for="period" class="block text-sm font-semibold text-gray-700">
                                                                                                Period
                                                                                            </label>
                                                                                            <select 
                                                                                                id="period" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white text-center"
                                                                                            >
                                                                                                <option value="AM">AM</option>
                                                                                                <option value="PM">PM</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- 24-Hour Input -->
                                                                                <div id="input24Hour" class="space-y-4 hidden">
                                                                                    <div class="grid grid-cols-2 gap-4">
                                                                                        <div class="space-y-2">
                                                                                            <label for="hour24" class="block text-sm font-semibold text-gray-700">
                                                                                                Hour (0-23)
                                                                                            </label>
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="hour24" 
                                                                                                min="0" 
                                                                                                max="23" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono text-center" 
                                                                                                placeholder="00"
                                                                                            >
                                                                                        </div>

                                                                                        <div class="space-y-2">
                                                                                            <label for="minute24" class="block text-sm font-semibold text-gray-700">
                                                                                                Minute (0-59)
                                                                                            </label>
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="minute24" 
                                                                                                min="0" 
                                                                                                max="59" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono text-center" 
                                                                                                placeholder="00"
                                                                                            >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <!-- Include Seconds -->
                                                                            <div class="space-y-2">
                                                                                <label class="flex items-center space-x-2">
                                                                                    <input type="checkbox" id="includeSeconds" class="text-emerald-600 focus:ring-slate-200">
                                                                                    <span class="text-sm font-semibold text-gray-700">Include Seconds</span>
                                                                                </label>
                                                                                <div id="secondsContainer" class="hidden">
                                                                                    <div class="w-full md:w-1/3">
                                                                                        <label for="seconds" class="block text-sm font-semibold text-gray-700 mb-2">
                                                                                            Seconds (0-59)
                                                                                        </label>
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="seconds" 
                                                                                            min="0" 
                                                                                            max="59" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono text-center" 
                                                                                            placeholder="00"
                                                                                        >
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border-l-4 border-emerald-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Military Time</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-3xl font-bold text-emerald-600 font-mono" id="output">--:--</div>
                                                                                        <button class="text-xs text-emerald-600 hover:text-emerald-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Both Time Formats -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- 12-Hour Format -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">12-Hour Format</h4>
                                                                                        <div class="text-xl font-bold text-blue-600 font-mono" id="display12Hour">--:-- --</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Standard Time</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- 24-Hour Format -->
                                                                                <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">24-Hour Format</h4>
                                                                                        <div class="text-xl font-bold text-emerald-600 font-mono" id="display24Hour">--:--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Military Time</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Time Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Time Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-hour="12" data-minute="00" data-period="AM">Midnight</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-hour="12" data-minute="00" data-period="PM">Noon</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-hour="6" data-minute="30" data-period="AM">Morning</button>
                                                            <button type="button" class="time-example px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-current="true">Current</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Military Time Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Military Time Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>00:00</strong> = 12:00 AM (Midnight)</div>
                                                        <div><strong>06:00</strong> = 6:00 AM</div>
                                                        <div><strong>12:00</strong> = 12:00 PM (Noon)</div>
                                                        <div><strong>18:00</strong> = 6:00 PM</div>
                                                        <div><strong>01:00</strong> = 1:00 AM</div>
                                                        <div><strong>13:00</strong> = 1:00 PM</div>
                                                        <div><strong>23:59</strong> = 11:59 PM</div>
                                                        <div><strong>24:00</strong> = Next day 00:00</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const modeRadios = document.getElementsByName('mode');
                        const includeSeconds = document.getElementById('includeSeconds');
                        const secondsContainer = document.getElementById('secondsContainer');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Input elements
                        const hour12 = document.getElementById('hour12');
                        const minute12 = document.getElementById('minute12');
                        const period = document.getElementById('period');
                        const hour24 = document.getElementById('hour24');
                        const minute24 = document.getElementById('minute24');
                        const seconds = document.getElementById('seconds');
                        
                        // Current time elements
                        const current12Hour = document.getElementById('current12Hour');
                        const current24Hour = document.getElementById('current24Hour');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const display12Hour = document.getElementById('display12Hour');
                        const display24Hour = document.getElementById('display24Hour');
                        const copyResult = document.getElementById('copyResult');

                        let updateInterval;


                        function updateCurrentTime() {
                            const now = new Date();
                            const hour = now.getHours();
                            const minute = now.getMinutes().toString().padStart(2, '0');
                            const second = now.getSeconds().toString().padStart(2, '0');
                            
                            // 12-hour format
                            const hour12Format = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
                            const periodFormat = hour >= 12 ? 'PM' : 'AM';
                            current12Hour.textContent = `${hour12Format}:${minute}:${second} ${periodFormat}`;
                            
                            // 24-hour format
                            current24Hour.textContent = `${hour.toString().padStart(2, '0')}:${minute}:${second}`;
                        }

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function updateInterface() {
                            const mode = getMode();
                            const input12Hour = document.getElementById('input12Hour');
                            const input24Hour = document.getElementById('input24Hour');
                            
                            if (mode === '12-to-24') {
                                input12Hour.classList.remove('hidden');
                                input24Hour.classList.add('hidden');
                                resultTitle.textContent = 'Military Time';
                                resultDescription.textContent = 'Converted to 24-hour format';
                            } else {
                                input12Hour.classList.add('hidden');
                                input24Hour.classList.remove('hidden');
                                resultTitle.textContent = 'Standard Time';
                                resultDescription.textContent = 'Converted to 12-hour format';
                            }
                        }

                        function convert() {
                            const mode = getMode();
                            const includeSecondsVal = includeSeconds.checked;
                            const secondsVal = includeSecondsVal ? (parseInt(seconds.value) || 0) : 0;
                            
                            let hour12Val, minute12Val, periodVal;
                            let hour24Val, minute24Val;
                            let isValid = false;
                            
                            if (mode === '12-to-24') {
                                hour12Val = parseInt(hour12.value);
                                minute12Val = parseInt(minute12.value) || 0;
                                periodVal = period.value;
                                
                                if (hour12Val && hour12Val >= 1 && hour12Val <= 12 && minute12Val >= 0 && minute12Val <= 59) {
                                    // Convert to 24-hour
                                    if (hour12Val === 12 && periodVal === 'AM') {
                                        hour24Val = 0;
                                    } else if (hour12Val === 12 && periodVal === 'PM') {
                                        hour24Val = 12;
                                    } else if (periodVal === 'AM') {
                                        hour24Val = hour12Val;
                                    } else {
                                        hour24Val = hour12Val + 12;
                                    }
                                    minute24Val = minute12Val;
                                    isValid = true;
                                }
                            } else {
                                hour24Val = parseInt(hour24.value);
                                minute24Val = parseInt(minute24.value) || 0;
                                
                                if (hour24Val !== undefined && hour24Val >= 0 && hour24Val <= 23 && minute24Val >= 0 && minute24Val <= 59) {
                                    // Convert to 12-hour
                                    if (hour24Val === 0) {
                                        hour12Val = 12;
                                        periodVal = 'AM';
                                    } else if (hour24Val < 12) {
                                        hour12Val = hour24Val;
                                        periodVal = 'AM';
                                    } else if (hour24Val === 12) {
                                        hour12Val = 12;
                                        periodVal = 'PM';
                                    } else {
                                        hour12Val = hour24Val - 12;
                                        periodVal = 'PM';
                                    }
                                    minute12Val = minute24Val;
                                    isValid = true;
                                }
                            }
                            
                            if (isValid) {
                                // Format displays
                                const hour24Str = hour24Val.toString().padStart(2, '0');
                                const minute24Str = minute24Val.toString().padStart(2, '0');
                                const secondsStr = secondsVal.toString().padStart(2, '0');
                                const minuteStr = minute12Val.toString().padStart(2, '0');
                                
                                const time12Format = includeSecondsVal ? 
                                    `${hour12Val}:${minuteStr}:${secondsStr} ${periodVal}` : 
                                    `${hour12Val}:${minuteStr} ${periodVal}`;
                                const time24Format = includeSecondsVal ? 
                                    `${hour24Str}:${minute24Str}:${secondsStr}` : 
                                    `${hour24Str}:${minute24Str}`;
                                
                                // Update primary output
                                output.textContent = mode === '12-to-24' ? time24Format : time12Format;
                                
                                // Update displays
                                display12Hour.textContent = time12Format;
                                display24Hour.textContent = time24Format;

                                resultDescription.textContent = mode === '12-to-24'
                                    ? `${time12Format} in 24-hour format`
                                    : `${time24Format} in 12-hour format`;
                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--:--';
                            display12Hour.textContent = '--:-- --';
                            display24Hour.textContent = '--:--';
                            resultDescription.textContent = getMode() === '12-to-24' ? 'Converted to 24-hour format' : 'Converted to 12-hour format';
                        }

                        function clearAll() {
                            hour12.value = '';
                            minute12.value = '';
                            period.value = 'AM';
                            hour24.value = '';
                            minute24.value = '';
                            seconds.value = '';
                            includeSeconds.checked = false;
                            secondsContainer.classList.add('hidden');
                            document.querySelector('input[value="12-to-24"]').checked = true;
                            updateInterface();
                            clearOutputs();
                        }

                        function setCurrentTime() {
                            const now = new Date();
                            const hour = now.getHours();
                            const minute = now.getMinutes();
                            const second = now.getSeconds();
                            
                            if (getMode() === '12-to-24') {
                                const hour12Format = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
                                const periodFormat = hour >= 12 ? 'PM' : 'AM';
                                
                                hour12.value = hour12Format;
                                minute12.value = minute;
                                period.value = periodFormat;
                            } else {
                                hour24.value = hour;
                                minute24.value = minute;
                            }
                            
                            if (includeSeconds.checked) {
                                seconds.value = second;
                            }
                            
                            convert();
                        }

                        // Event listeners
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        includeSeconds.addEventListener('change', function() {
                            if (this.checked) {
                                secondsContainer.classList.remove('hidden');
                            } else {
                                secondsContainer.classList.add('hidden');
                            }
                            convert();
                        });

                        [hour12, minute12, period, hour24, minute24, seconds].forEach(input => {
                            if (input) {
                                input.addEventListener('input', convert);
                                input.addEventListener('change', convert);
                            }
                        });

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--:--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        // Example buttons
                        const timeExamples = document.querySelectorAll('.time-example');
                        timeExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const isCurrent = this.getAttribute('data-current');
                                
                                if (isCurrent) {
                                    setCurrentTime();
                                } else {
                                    const exampleHour = this.getAttribute('data-hour');
                                    const exampleMinute = this.getAttribute('data-minute');
                                    const examplePeriod = this.getAttribute('data-period');
                                    
                                    // Set to 12-to-24 mode
                                    document.querySelector('input[value="12-to-24"]').checked = true;
                                    updateInterface();
                                    
                                    hour12.value = exampleHour;
                                    minute12.value = exampleMinute;
                                    period.value = examplePeriod;
                                    convert();
                                }
                                
                                // Update button styles
                                timeExamples.forEach(btn => btn.classList.remove('bg-emerald-100', 'text-emerald-700'));
                                timeExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-emerald-100', 'text-emerald-700');
                            });
                        });

                        // Initialize
                        updateInterface();
                        updateCurrentTime();
                        
                        // Update current time every second
                        updateInterval = setInterval(updateCurrentTime, 1000);

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                const currentMode = getMode();
                                const newMode = currentMode === '12-to-24' ? '24-to-12' : '12-to-24';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateInterface();
                                convert();
                            } else if (e.ctrlKey && e.key === 't') {
                                e.preventDefault();
                                setCurrentTime();
                            }
                        });

                        // Cleanup interval on page unload
                        window.addEventListener('beforeunload', function() {
                            if (updateInterval) {
                                clearInterval(updateInterval);
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
