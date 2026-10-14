<x-tool-page-layout
    title="Unix Time Converter - SolveKit"
    description="Professional Unix timestamp converter for developers and system administrators. Convert between Unix timestamps and human-readable dates with timezone support and detailed analysis."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Unix Time Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                <!-- Current Time Display -->
                                <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Current Time</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600 block">Unix Timestamp:</span>
                                            <span class="font-mono text-blue-700 cursor-pointer hover:text-blue-900" id="currentUnix" title="Click to use">--</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 block">Human Date:</span>
                                            <span class="font-mono text-blue-700" id="currentHuman">--</span>
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
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors cursor-pointer bg-orange-50 border-orange-300">
                                                                                        <input type="radio" name="mode" value="unix-to-date" class="text-orange-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Unix → Date</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="date-to-unix" class="text-orange-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Date → Unix</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Container -->
                                                                            <div id="inputContainer">

                                                                                <!-- Unix Timestamp Input -->
                                                                                <div id="unixInput" class="space-y-2">
                                                                                    <label for="unixValue" class="block text-sm font-semibold text-gray-700">
                                                                                        Enter Unix Timestamp
                                                                                    </label>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="unixValue" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                            placeholder="Enter Unix timestamp (e.g., 1721744947)"
                                                                                            step="1"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-sm font-medium">Unix</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <p class="text-xs text-gray-500">Seconds since January 1, 1970 (UTC)</p>
                                                                                </div>

                                                                                <!-- Date Input -->
                                                                                <div id="dateInput" class="space-y-4 hidden">
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                        <div class="space-y-2">
                                                                                            <label for="dateValue" class="block text-sm font-semibold text-gray-700">
                                                                                                Date
                                                                                            </label>
                                                                                            <input 
                                                                                                type="date" 
                                                                                                id="dateValue" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono"
                                                                                            >
                                                                                        </div>

                                                                                        <div class="space-y-2">
                                                                                            <label for="timeValue" class="block text-sm font-semibold text-gray-700">
                                                                                                Time (24h)
                                                                                            </label>
                                                                                            <input 
                                                                                                type="time" 
                                                                                                id="timeValue" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono"
                                                                                                step="1"
                                                                                            >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <!-- Timezone Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="timezone" class="block text-sm font-semibold text-gray-700">
                                                                                    Timezone for Display
                                                                                </label>
                                                                                <select 
                                                                                    id="timezone" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="UTC">UTC (Coordinated Universal Time)</option>
                                                                                    <option value="America/New_York">Eastern Time (ET)</option>
                                                                                    <option value="America/Chicago">Central Time (CT)</option>
                                                                                    <option value="America/Denver">Mountain Time (MT)</option>
                                                                                    <option value="America/Los_Angeles">Pacific Time (PT)</option>
                                                                                    <option value="Europe/London">London (GMT/BST)</option>
                                                                                    <option value="Europe/Paris">Paris (CET/CEST)</option>
                                                                                    <option value="Europe/Berlin">Berlin (CET/CEST)</option>
                                                                                    <option value="Asia/Tokyo">Tokyo (JST)</option>
                                                                                    <option value="Asia/Shanghai">Shanghai (CST)</option>
                                                                                    <option value="Asia/Kolkata">India (IST)</option>
                                                                                    <option value="Australia/Sydney">Sydney (AEST/AEDT)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Timestamp Format -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Timestamp Format
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors cursor-pointer bg-orange-50 border-orange-300">
                                                                                        <input type="radio" name="format" value="seconds" class="text-orange-600 focus:ring-slate-200" checked>
                                                                                        <div class="text-left">
                                                                                            <div class="text-sm font-medium">Seconds</div>
                                                                                            <div class="text-xs text-gray-500">Standard Unix time</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-orange-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="format" value="milliseconds" class="text-orange-600 focus:ring-slate-200">
                                                                                        <div class="text-left">
                                                                                            <div class="text-sm font-medium">Milliseconds</div>
                                                                                            <div class="text-xs text-gray-500">JavaScript format</div>
                                                                                        </div>
                                                                                    </label>
                                                                                </div>
                                                                            </div>



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
                                                                            <div class="p-6 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl border-l-4 border-orange-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Human-Readable Date</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-xl font-bold text-orange-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-orange-600 hover:text-orange-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Timestamp Formats -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Unix Timestamp -->
                                                                                <div class="p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg border-l-4 border-gray-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Unix Timestamp</h4>
                                                                                        <div class="text-lg font-bold text-gray-600 font-mono" id="unixDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Seconds since epoch</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Milliseconds -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Milliseconds</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="millisecondsDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">JavaScript format</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="hidden">
                                                                                <!-- Date Formats -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                                                                                    <h4 class="text-sm font-semibold text-green-800 mb-2 text-center">Multiple Date Formats</h4>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                                                        <div>
                                                                                            <span class="text-gray-600 block">ISO 8601:</span>
                                                                                            <span class="font-mono text-green-700" id="isoFormat">--</span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <span class="text-gray-600 block">RFC 2822:</span>
                                                                                            <span class="font-mono text-green-700" id="rfcFormat">--</span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <span class="text-gray-600 block">US Format:</span>
                                                                                            <span class="font-mono text-green-700" id="usFormat">--</span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <span class="text-gray-600 block">European:</span>
                                                                                            <span class="font-mono text-green-700" id="euFormat">--</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Time Analysis -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                                                                    <h4 class="text-sm font-semibold text-blue-800 mb-2 text-center">Time Analysis</h4>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Days since Epoch:</span>
                                                                                            <span class="font-mono text-blue-700" id="daysSinceEpoch">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Day of Week:</span>
                                                                                            <span class="font-mono text-blue-700" id="dayOfWeek">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Week of Year:</span>
                                                                                            <span class="font-mono text-blue-700" id="weekOfYear">--</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Timezone Information -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border border-purple-200">
                                                                                    <h4 class="text-sm font-semibold text-purple-800 mb-2 text-center">Timezone Information</h4>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Selected Timezone:</span>
                                                                                            <span class="font-mono text-purple-700" id="selectedTimezone">UTC</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">UTC Offset:</span>
                                                                                            <span class="font-mono text-purple-700" id="utcOffset">+00:00</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Relative Time -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border border-pink-200">
                                                                                    <h4 class="text-sm font-semibold text-pink-800 mb-2 text-center">Relative Time</h4>
                                                                                    <div class="text-sm text-pink-700 text-center" id="relativeTime">--</div>
                                                                                </div>

                                                                                <!-- Programming Context -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border border-cyan-200">
                                                                                    <h4 class="text-sm font-semibold text-cyan-800 mb-2 text-center">Programming Context</h4>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                                                        <div>
                                                                                            <span class="text-gray-600 block">JavaScript:</span>
                                                                                            <span class="font-mono text-cyan-700" id="jsCode">--</span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <span class="text-gray-600 block">Python:</span>
                                                                                            <span class="font-mono text-cyan-700" id="pythonCode">--</span>
                                                                                        </div>
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
                <!-- Quick Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unix-example px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-value="0">Unix Epoch</button>
                                                            <button type="button" class="unix-example px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-value="1000000000">1B Seconds</button>
                                                            <button type="button" class="unix-example px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-value="1577836800">Y2K+20</button>
                                                            <button type="button" class="unix-example px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-current="true">Current</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Unix Time Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Unix Time Reference</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div><strong>Epoch Start:</strong> January 1, 1970 00:00:00 UTC</div>
                                                        <div><strong>32-bit Limit:</strong> January 19, 2038 03:14:07 UTC</div>
                                                        <div><strong>Current:</strong> <span id="currentTimestamp">--</span></div>
                                                        <div><strong>Range:</strong> -2,147,483,648 to 2,147,483,647</div>
                                                        <div><strong>Precision:</strong> 1 second (use milliseconds for higher precision)</div>
                                                        <div><strong>Y2K38 Problem:</strong> 32-bit signed integer overflow in 2038</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const modeRadios = document.getElementsByName('mode');
                        const formatRadios = document.getElementsByName('format');
                        const unixValue = document.getElementById('unixValue');
                        const dateValue = document.getElementById('dateValue');
                        const timeValue = document.getElementById('timeValue');
                        const timezone = document.getElementById('timezone');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Current time elements
                        const currentUnix = document.getElementById('currentUnix');
                        const currentHuman = document.getElementById('currentHuman');
                        const currentTimestamp = document.getElementById('currentTimestamp');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const unixDisplay = document.getElementById('unixDisplay');
                        const millisecondsDisplay = document.getElementById('millisecondsDisplay');
                        const isoFormat = document.getElementById('isoFormat');
                        const rfcFormat = document.getElementById('rfcFormat');
                        const usFormat = document.getElementById('usFormat');
                        const euFormat = document.getElementById('euFormat');
                        const daysSinceEpoch = document.getElementById('daysSinceEpoch');
                        const dayOfWeek = document.getElementById('dayOfWeek');
                        const weekOfYear = document.getElementById('weekOfYear');
                        const selectedTimezone = document.getElementById('selectedTimezone');
                        const utcOffset = document.getElementById('utcOffset');
                        const relativeTime = document.getElementById('relativeTime');
                        const jsCode = document.getElementById('jsCode');
                        const pythonCode = document.getElementById('pythonCode');
                        const copyResult = document.getElementById('copyResult');

                        let updateInterval;

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function getFormat() {
                            return document.querySelector('input[name="format"]:checked').value;
                        }

                        function updateCurrentTime() {
                            const now = new Date();
                            const unixTimestamp = Math.floor(now.getTime() / 1000);
                            
                            currentUnix.textContent = unixTimestamp.toLocaleString();
                            currentHuman.textContent = now.toISOString().replace('T', ' ').slice(0, 19) + ' UTC';
                            currentTimestamp.textContent = unixTimestamp.toLocaleString();
                        }

                        function updateInterface() {
                            const mode = getMode();
                            const unixInput = document.getElementById('unixInput');
                            const dateInput = document.getElementById('dateInput');
                            
                            if (mode === 'unix-to-date') {
                                unixInput.classList.remove('hidden');
                                dateInput.classList.add('hidden');
                                resultTitle.textContent = 'Human-Readable Date';
                                resultDescription.textContent = 'Converted from Unix timestamp';
                            } else {
                                unixInput.classList.add('hidden');
                                dateInput.classList.remove('hidden');
                                resultTitle.textContent = 'Unix Timestamp';
                                resultDescription.textContent = 'Converted from date/time';
                            }
                        }

                        function getWeekNumber(date) {
                            const firstDayOfYear = new Date(date.getFullYear(), 0, 1);
                            const pastDaysOfYear = (date.getTime() - firstDayOfYear.getTime()) / 86400000;
                            return Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);
                        }

                        function getRelativeTime(timestamp) {
                            const now = Math.floor(Date.now() / 1000);
                            const diff = now - timestamp;
                            const absDiff = Math.abs(diff);
                            
                            const intervals = [
                                { label: 'year', seconds: 31536000 },
                                { label: 'month', seconds: 2592000 },
                                { label: 'week', seconds: 604800 },
                                { label: 'day', seconds: 86400 },
                                { label: 'hour', seconds: 3600 },
                                { label: 'minute', seconds: 60 },
                                { label: 'second', seconds: 1 }
                            ];
                            
                            for (const interval of intervals) {
                                const count = Math.floor(absDiff / interval.seconds);
                                if (count >= 1) {
                                    const plural = count > 1 ? 's' : '';
                                    const prefix = diff < 0 ? 'in ' : '';
                                    const suffix = diff < 0 ? '' : ' ago';
                                    return `${prefix}${count} ${interval.label}${plural}${suffix}`;
                                }
                            }
                            
                            return 'just now';
                        }

                        function formatInTimezone(date, tz) {
                            try {
                                return date.toLocaleString('en-US', { 
                                    timeZone: tz,
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit',
                                    hour12: false
                                });
                            } catch (e) {
                                return date.toISOString().replace('T', ' ').slice(0, 19);
                            }
                        }

                        function getTimezoneOffset(date, tz) {
                            try {
                                const utcDate = new Date(date.toLocaleString('en-US', { timeZone: 'UTC' }));
                                const tzDate = new Date(date.toLocaleString('en-US', { timeZone: tz }));
                                const offset = (tzDate.getTime() - utcDate.getTime()) / (1000 * 60);
                                const hours = Math.floor(Math.abs(offset) / 60);
                                const minutes = Math.abs(offset) % 60;
                                const sign = offset >= 0 ? '+' : '-';
                                return `${sign}${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
                            } catch (e) {
                                return '+00:00';
                            }
                        }

                        function convert() {
                            const mode = getMode();
                            const format = getFormat();
                            const tz = timezone.value;
                            
                            let timestamp, date;
                            
                            try {
                                if (mode === 'unix-to-date') {
                                    const inputVal = parseFloat(unixValue.value);
                                    if (isNaN(inputVal)) {
                                        clearOutputs();
                                        return;
                                    }
                                    
                                    timestamp = format === 'milliseconds' ? Math.floor(inputVal / 1000) : inputVal;
                                    date = new Date(timestamp * 1000);
                                } else {
                                    const dateStr = dateValue.value;
                                    const timeStr = timeValue.value || '00:00:00';
                                    
                                    if (!dateStr) {
                                        clearOutputs();
                                        return;
                                    }
                                    
                                    // Create date in UTC
                                    const combinedStr = `${dateStr}T${timeStr}:00Z`;
                                    date = new Date(combinedStr);
                                    timestamp = Math.floor(date.getTime() / 1000);
                                }
                                
                                if (isNaN(date.getTime())) {
                                    clearOutputs();
                                    return;
                                }
                                
                                // Update primary output
                                if (mode === 'unix-to-date') {
                                    output.textContent = formatInTimezone(date, tz);
                                    resultDescription.textContent = `Unix ${timestamp.toLocaleString()} → Date (${tz})`;
                                } else {
                                    const outputTimestamp = format === 'milliseconds' ? timestamp * 1000 : timestamp;
                                    output.textContent = outputTimestamp.toLocaleString();
                                    resultDescription.textContent = `Date → Unix ${format}`;
                                }
                                
                                // Update displays
                                unixDisplay.textContent = timestamp.toLocaleString();
                                millisecondsDisplay.textContent = (timestamp * 1000).toLocaleString();
                                
                                // Date formats
                                isoFormat.textContent = date.toISOString();
                                rfcFormat.textContent = date.toUTCString();
                                usFormat.textContent = date.toLocaleDateString('en-US') + ' ' + date.toLocaleTimeString('en-US');
                                euFormat.textContent = date.toLocaleDateString('en-GB') + ' ' + date.toLocaleTimeString('en-GB');
                                
                                // Time analysis
                                daysSinceEpoch.textContent = Math.floor(timestamp / 86400).toLocaleString();
                                dayOfWeek.textContent = date.toLocaleDateString('en-US', { weekday: 'long' });
                                weekOfYear.textContent = getWeekNumber(date);
                                
                                // Timezone info
                                selectedTimezone.textContent = tz;
                                utcOffset.textContent = getTimezoneOffset(date, tz);
                                
                                // Relative time
                                relativeTime.textContent = getRelativeTime(timestamp);
                                
                                // Programming context
                                jsCode.textContent = `new Date(${timestamp * 1000})`;
                                pythonCode.textContent = `datetime.fromtimestamp(${timestamp})`;
                                
                            } catch (error) {
                                clearOutputs();
                                console.error('Conversion error:', error);
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultDescription.textContent = 'Converted result';
                            unixDisplay.textContent = '--';
                            millisecondsDisplay.textContent = '--';
                            isoFormat.textContent = '--';
                            rfcFormat.textContent = '--';
                            usFormat.textContent = '--';
                            euFormat.textContent = '--';
                            daysSinceEpoch.textContent = '--';
                            dayOfWeek.textContent = '--';
                            weekOfYear.textContent = '--';
                            selectedTimezone.textContent = 'UTC';
                            utcOffset.textContent = '+00:00';
                            relativeTime.textContent = '--';
                            jsCode.textContent = '--';
                            pythonCode.textContent = '--';
                        }

                        function clearAll() {
                            unixValue.value = '';
                            dateValue.value = '';
                            timeValue.value = '';
                            document.querySelector('input[value="unix-to-date"]').checked = true;
                            document.querySelector('input[value="seconds"]').checked = true;
                            timezone.value = 'UTC';
                            updateInterface();
                            clearOutputs();
                        }

                        function setCurrentTime() {
                            const now = new Date();
                            const timestamp = Math.floor(now.getTime() / 1000);
                            
                            if (getMode() === 'unix-to-date') {
                                unixValue.value = timestamp;
                            } else {
                                const isoString = now.toISOString();
                                dateValue.value = isoString.split('T')[0];
                                timeValue.value = isoString.split('T')[1].slice(0, 8);
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

                        formatRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        unixValue.addEventListener('input', convert);
                        dateValue.addEventListener('change', convert);
                        timeValue.addEventListener('change', convert);
                        timezone.addEventListener('change', convert);

                        clearButton.addEventListener('click', clearAll);

                        // Current time click handler
                        currentUnix.addEventListener('click', function() {
                            if (getMode() === 'unix-to-date') {
                                unixValue.value = Math.floor(Date.now() / 1000);
                                convert();
                            }
                        });

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
                        const unixExamples = document.querySelectorAll('.unix-example');
                        unixExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const isCurrent = this.getAttribute('data-current');
                                
                                // Set to unix-to-date mode
                                document.querySelector('input[value="unix-to-date"]').checked = true;
                                updateInterface();
                                
                                if (isCurrent) {
                                    unixValue.value = Math.floor(Date.now() / 1000);
                                } else {
                                    unixValue.value = value;
                                }
                                convert();
                                
                                // Update button styles
                                unixExamples.forEach(btn => btn.classList.remove('bg-orange-100', 'text-orange-700'));
                                unixExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-orange-100', 'text-orange-700');
                            });
                        });

                        // Initialize
                        updateInterface();
                        updateCurrentTime();
                        
                        // Update current time every second
                        updateInterval = setInterval(updateCurrentTime, 1000);

                        // Set current date/time as default
                        const now = new Date();
                        const isoString = now.toISOString();
                        dateValue.value = isoString.split('T')[0];
                        timeValue.value = isoString.split('T')[1].slice(0, 8);

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                const currentMode = getMode();
                                const newMode = currentMode === 'unix-to-date' ? 'date-to-unix' : 'unix-to-date';
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
