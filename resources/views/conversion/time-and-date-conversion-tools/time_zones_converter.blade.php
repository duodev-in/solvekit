<x-tool-page-layout
    title="Time Zones Converter - ConvertPro"
    description="Professional time zone converter for global time calculations. Convert time between different time zones worldwide with DST support and real-time updates."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h2 class="text-lg font-semibold text-white">Global Time Zone Converter</h2>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                <!-- Current Time Display -->
                                <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                    <h3 class="text-sm font-semibold text-blue-800 mb-3">Current Time (Real-time)</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600 block">UTC:</span>
                                            <span class="font-mono text-blue-700 text-lg" id="currentUTC">2025-07-23 14:46:06</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 block">Local Time:</span>
                                            <span class="font-mono text-blue-700 text-lg" id="currentLocal">--</span>
                                        </div>
                                    </div>

                                </div>

                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Source Time Input -->
                                                                            <div class="space-y-4">
                                                                                <h3 class="text-lg font-semibold text-gray-800">Source Time</h3>

                                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                    <div class="space-y-2">
                                                                                        <label for="sourceDate" class="block text-sm font-semibold text-gray-700">
                                                                                            Date
                                                                                        </label>
                                                                                        <input 
                                                                                            type="date" 
                                                                                            id="sourceDate" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono"
                                                                                            value="2025-07-23"
                                                                                        >
                                                                                    </div>

                                                                                    <div class="space-y-2">
                                                                                        <label for="sourceTime" class="block text-sm font-semibold text-gray-700">
                                                                                            Time (24h)
                                                                                        </label>
                                                                                        <input 
                                                                                            type="time" 
                                                                                            id="sourceTime" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono"
                                                                                            step="1"
                                                                                            value="14:46:06"
                                                                                        >
                                                                                    </div>
                                                                                </div>

                                                                                <div class="space-y-2">
                                                                                    <label for="sourceTimezone" class="block text-sm font-semibold text-gray-700">
                                                                                        Source Time Zone
                                                                                    </label>
                                                                                    <select 
                                                                                        id="sourceTimezone" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="UTC" selected>UTC - Coordinated Universal Time</option>
                                                                                        <optgroup label="North America">
                                                                                            <option value="America/New_York">Eastern Time (ET) - New York</option>
                                                                                            <option value="America/Chicago">Central Time (CT) - Chicago</option>
                                                                                            <option value="America/Denver">Mountain Time (MT) - Denver</option>
                                                                                            <option value="America/Los_Angeles">Pacific Time (PT) - Los Angeles</option>
                                                                                            <option value="America/Anchorage">Alaska Time (AKST) - Anchorage</option>
                                                                                            <option value="Pacific/Honolulu">Hawaii Time (HST) - Honolulu</option>
                                                                                            <option value="America/Toronto">Eastern Time - Toronto</option>
                                                                                            <option value="America/Vancouver">Pacific Time - Vancouver</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Europe">
                                                                                            <option value="Europe/London">GMT/BST - London</option>
                                                                                            <option value="Europe/Paris">CET/CEST - Paris</option>
                                                                                            <option value="Europe/Berlin">CET/CEST - Berlin</option>
                                                                                            <option value="Europe/Rome">CET/CEST - Rome</option>
                                                                                            <option value="Europe/Madrid">CET/CEST - Madrid</option>
                                                                                            <option value="Europe/Amsterdam">CET/CEST - Amsterdam</option>
                                                                                            <option value="Europe/Moscow">MSK - Moscow</option>
                                                                                            <option value="Europe/Istanbul">TRT - Istanbul</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Asia">
                                                                                            <option value="Asia/Tokyo">JST - Tokyo</option>
                                                                                            <option value="Asia/Shanghai">CST - Shanghai</option>
                                                                                            <option value="Asia/Hong_Kong">HKT - Hong Kong</option>
                                                                                            <option value="Asia/Singapore">SGT - Singapore</option>
                                                                                            <option value="Asia/Seoul">KST - Seoul</option>
                                                                                            <option value="Asia/Kolkata">IST - Mumbai/Delhi</option>
                                                                                            <option value="Asia/Dubai">GST - Dubai</option>
                                                                                            <option value="Asia/Bangkok">ICT - Bangkok</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Australia & Pacific">
                                                                                            <option value="Australia/Sydney">AEST/AEDT - Sydney</option>
                                                                                            <option value="Australia/Melbourne">AEST/AEDT - Melbourne</option>
                                                                                            <option value="Australia/Perth">AWST - Perth</option>
                                                                                            <option value="Pacific/Auckland">NZST/NZDT - Auckland</option>
                                                                                            <option value="Pacific/Fiji">FJT - Fiji</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="Africa & Middle East">
                                                                                            <option value="Africa/Cairo">EET - Cairo</option>
                                                                                            <option value="Africa/Lagos">WAT - Lagos</option>
                                                                                            <option value="Africa/Johannesburg">SAST - Johannesburg</option>
                                                                                            <option value="Asia/Riyadh">AST - Riyadh</option>
                                                                                        </optgroup>
                                                                                        <optgroup label="South America">
                                                                                            <option value="America/Sao_Paulo">BRT - São Paulo</option>
                                                                                            <option value="America/Argentina/Buenos_Aires">ART - Buenos Aires</option>
                                                                                            <option value="America/Santiago">CLT - Santiago</option>
                                                                                            <option value="America/Lima">PET - Lima</option>
                                                                                        </optgroup>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Target Time Zones -->
                                                                            <div class="space-y-4">
                                                                                <h3 class="text-lg font-semibold text-gray-800">Convert To (Multiple Time Zones)</h3>

                                                                                <div class="space-y-2">
                                                                                    <label class="block text-sm font-semibold text-gray-700">
                                                                                        Select Target Time Zones
                                                                                    </label>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="America/New_York" class="text-amber-600 focus:ring-slate-200" checked>
                                                                                            <span class="text-sm">New York (ET)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="Europe/London" class="text-amber-600 focus:ring-slate-200" checked>
                                                                                            <span class="text-sm">London (GMT/BST)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="Asia/Tokyo" class="text-amber-600 focus:ring-slate-200" checked>
                                                                                            <span class="text-sm">Tokyo (JST)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="Australia/Sydney" class="text-amber-600 focus:ring-slate-200">
                                                                                            <span class="text-sm">Sydney (AEST/AEDT)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="America/Los_Angeles" class="text-amber-600 focus:ring-slate-200">
                                                                                            <span class="text-sm">Los Angeles (PT)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="Europe/Paris" class="text-amber-600 focus:ring-slate-200">
                                                                                            <span class="text-sm">Paris (CET/CEST)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="Asia/Shanghai" class="text-amber-600 focus:ring-slate-200">
                                                                                            <span class="text-sm">Shanghai (CST)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="Asia/Kolkata" class="text-amber-600 focus:ring-slate-200">
                                                                                            <span class="text-sm">Mumbai (IST)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="America/Sao_Paulo" class="text-amber-600 focus:ring-slate-200">
                                                                                            <span class="text-sm">São Paulo (BRT)</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 hover:bg-amber-50 rounded cursor-pointer">
                                                                                            <input type="checkbox" name="targetTimezone" value="Asia/Dubai" class="text-amber-600 focus:ring-slate-200">
                                                                                            <span class="text-sm">Dubai (GST)</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Reset All
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Values</h3>

                                                                            <!-- Source Time Display -->
                                                                            <div class="p-6 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl border-l-4 border-amber-500">
                                                                                <div class="text-center">
                                                                                    <h4 class="text-lg font-semibold text-gray-800 mb-1">Source Time</h4>
                                                                                    <div class="text-2xl font-bold text-amber-600 font-mono" id="sourceDisplay">2025-07-23 14:46:06 UTC</div>
                                                                                    <p class="text-sm text-gray-600 mt-2" id="sourceDescription">Coordinated Universal Time</p>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Target Time Zones Display -->
                                                                            <div class="space-y-3" id="targetTimezones">
                                                                                <!-- Dynamic timezone cards will be inserted here -->
                                                                            </div>

                                                                            <!-- Time Differences -->
                                                                            <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                                                                <h4 class="text-sm font-semibold text-blue-800 mb-2 text-center">Time Differences from Source</h4>
                                                                                <div class="space-y-2" id="timeDifferences">
                                                                                    <!-- Dynamic time differences will be inserted here -->
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden">
                                                                                <!-- DST Information -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                                                                                    <h4 class="text-sm font-semibold text-green-800 mb-2 text-center">Daylight Saving Time Status</h4>
                                                                                    <div class="space-y-2" id="dstInfo">
                                                                                        <!-- Dynamic DST information will be inserted here -->
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Business Hours Analysis -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border border-purple-200">
                                                                                    <h4 class="text-sm font-semibold text-purple-800 mb-2 text-center">Business Hours Analysis</h4>
                                                                                    <div class="text-sm text-purple-700 text-center" id="businessHours">Select time zones to see business hours overlap</div>
                                                                                </div>

                                                                                <!-- Meeting Scheduler -->
                                                                                <div class="p-4 bg-gradient-to-r from-rose-50 to-pink-50 rounded-lg border border-rose-200">
                                                                                    <h4 class="text-sm font-semibold text-rose-800 mb-2 text-center">Meeting Time Recommendations</h4>
                                                                                    <div class="text-sm text-rose-700 text-center" id="meetingTimes">Best meeting times will appear here</div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Actions -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Actions
                                                        </label>
                                                        <div class="flex flex-wrap gap-2">
                                                            <button type="button" id="useCurrentTime" class="px-4 py-2 text-sm bg-amber-100 hover:bg-amber-200 text-amber-700 font-medium rounded-lg transition-colors">
                                                                Use Current Time
                                                            </button>
                                                            <button type="button" id="selectAllMajor" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                                                                Select Major Cities
                                                            </button>
                                                            <button type="button" id="clearSelections" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                                                                Clear All
                                                            </button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Time Zone Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Time Zone Abbreviations</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>UTC</strong> - Coordinated Universal Time</div>
                                                        <div><strong>GMT</strong> - Greenwich Mean Time</div>
                                                        <div><strong>EST/EDT</strong> - Eastern Standard/Daylight</div>
                                                        <div><strong>CST/CDT</strong> - Central Standard/Daylight</div>
                                                        <div><strong>MST/MDT</strong> - Mountain Standard/Daylight</div>
                                                        <div><strong>PST/PDT</strong> - Pacific Standard/Daylight</div>
                                                        <div><strong>CET/CEST</strong> - Central European Time</div>
                                                        <div><strong>JST</strong> - Japan Standard Time</div>
                                                        <div><strong>IST</strong> - India Standard Time</div>
                                                        <div><strong>AEST/AEDT</strong> - Australian Eastern Time</div>
                                                        <div><strong>BST</strong> - British Summer Time</div>
                                                        <div><strong>DST</strong> - Daylight Saving Time</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Time Zone Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Global Time Standards</h4>
                                    <p>Time zones are regions that observe a uniform standard time. The world is divided into 24 time zones, each typically 15 degrees of longitude apart. UTC (Coordinated Universal Time) serves as the primary time standard from which all time zones are calculated.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Daylight Saving Time</h4>
                                    <p>Many regions observe Daylight Saving Time (DST), shifting clocks forward by one hour during warmer months. This affects time zone calculations and can create temporary offset changes. Our converter automatically accounts for DST rules.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-amber-50 rounded-lg border border-amber-200">
                                <p class="text-sm text-amber-800">
                                    <strong>Global Tip:</strong> When scheduling international meetings, consider business hours and cultural working patterns in addition to time zone differences!
                                </p>
                            </div>
                        </div>

                        <!-- World Clock -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">World Clock (Live)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="worldClock">
                                <!-- Dynamic world clock will be populated here -->
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const sourceDate = document.getElementById('sourceDate');
                        const sourceTime = document.getElementById('sourceTime');
                        const sourceTimezone = document.getElementById('sourceTimezone');
                        const targetTimezoneCheckboxes = document.getElementsByName('targetTimezone');
                        const clearButton = document.getElementById('clearButton');
                        const useCurrentTime = document.getElementById('useCurrentTime');
                        const selectAllMajor = document.getElementById('selectAllMajor');
                        const clearSelections = document.getElementById('clearSelections');
                        
                        // Output elements
                        const currentUTC = document.getElementById('currentUTC');
                        const currentLocal = document.getElementById('currentLocal');
                        const sourceDisplay = document.getElementById('sourceDisplay');
                        const sourceDescription = document.getElementById('sourceDescription');
                        const targetTimezones = document.getElementById('targetTimezones');
                        const timeDifferences = document.getElementById('timeDifferences');
                        const dstInfo = document.getElementById('dstInfo');
                        const businessHours = document.getElementById('businessHours');
                        const meetingTimes = document.getElementById('meetingTimes');
                        const worldClock = document.getElementById('worldClock');

                        let updateInterval;

                        // Major time zones for world clock
                        const majorTimezones = [
                            { name: 'New York', timezone: 'America/New_York', code: 'ET' },
                            { name: 'London', timezone: 'Europe/London', code: 'GMT/BST' },
                            { name: 'Tokyo', timezone: 'Asia/Tokyo', code: 'JST' },
                            { name: 'Sydney', timezone: 'Australia/Sydney', code: 'AEST/AEDT' },
                            { name: 'Los Angeles', timezone: 'America/Los_Angeles', code: 'PT' },
                            { name: 'Dubai', timezone: 'Asia/Dubai', code: 'GST' }
                        ];

                        function updateCurrentTime() {
                            const now = new Date();
                            
                            // Update UTC time
                            currentUTC.textContent = now.toISOString().replace('T', ' ').slice(0, 19);
                            
                            // Update local time
                            const localTime = now.toLocaleString('sv-SE', { 
                                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone 
                            });
                            currentLocal.textContent = localTime + ' (' + Intl.DateTimeFormat().resolvedOptions().timeZone + ')';
                        }

                        function formatDateTimeForTimezone(date, timezone) {
                            try {
                                const options = {
                                    timeZone: timezone,
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit',
                                    hour12: false
                                };
                                
                                const formatted = new Intl.DateTimeFormat('sv-SE', options).format(date);
                                return formatted.replace(',', '');
                            } catch (e) {
                                return 'Invalid timezone';
                            }
                        }

                        function getTimezoneOffset(date, timezone) {
                            try {
                                const utcDate = new Date(date.toLocaleString('en-US', { timeZone: 'UTC' }));
                                const tzDate = new Date(date.toLocaleString('en-US', { timeZone: timezone }));
                                const offset = (tzDate.getTime() - utcDate.getTime()) / (1000 * 60);
                                const hours = Math.floor(Math.abs(offset) / 60);
                                const minutes = Math.abs(offset) % 60;
                                const sign = offset >= 0 ? '+' : '-';
                                return `${sign}${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
                            } catch (e) {
                                return '+00:00';
                            }
                        }

                        function getTimezoneAbbreviation(date, timezone) {
                            try {
                                return new Intl.DateTimeFormat('en-US', {
                                    timeZone: timezone,
                                    timeZoneName: 'short'
                                }).formatToParts(date).find(part => part.type === 'timeZoneName')?.value || timezone;
                            } catch (e) {
                                return timezone;
                            }
                        }

                        function isDST(date, timezone) {
                            try {
                                // Create dates for January and July to compare offsets
                                const jan = new Date(date.getFullYear(), 0, 1);
                                const jul = new Date(date.getFullYear(), 6, 1);
                                
                                const janOffset = getTimezoneOffset(jan, timezone);
                                const julOffset = getTimezoneOffset(jul, timezone);
                                const currentOffset = getTimezoneOffset(date, timezone);
                                
                                return currentOffset !== janOffset || currentOffset !== julOffset;
                            } catch (e) {
                                return false;
                            }
                        }

                        function analyzeBusinessHours(sourceDate, sourceTimezone, targetTimezones) {
                            const businessStart = 9; // 9 AM
                            const businessEnd = 17; // 5 PM
                            
                            const sourceTime = new Date(`${sourceDate.toDateString()} ${businessStart}:00:00`);
                            const analysis = [];
                            
                            targetTimezones.forEach(tz => {
                                const tzTime = new Date(sourceTime.toLocaleString('en-US', { timeZone: tz }));
                                const hour = tzTime.getHours();
                                
                                let status = 'Outside business hours';
                                if (hour >= businessStart && hour < businessEnd) {
                                    status = 'Business hours';
                                } else if (hour >= 6 && hour < businessStart) {
                                    status = 'Early morning';
                                } else if (hour >= businessEnd && hour < 22) {
                                    status = 'Evening';
                                } else {
                                    status = 'Night time';
                                }
                                
                                analysis.push(`${tz.split('/')[1]}: ${status}`);
                            });
                            
                            return analysis;
                        }

                        function suggestMeetingTimes(sourceTimezone, targetTimezones) {
                            const suggestions = [];
                            const timeSlots = [8, 9, 10, 11, 14, 15, 16, 17]; // Potential meeting hours
                            
                            timeSlots.forEach(hour => {
                                const testTime = new Date();
                                testTime.setHours(hour, 0, 0, 0);
                                
                                let suitableCount = 0;
                                targetTimezones.forEach(tz => {
                                    const tzTime = new Date(testTime.toLocaleString('en-US', { timeZone: tz }));
                                    const tzHour = tzTime.getHours();
                                    
                                    if (tzHour >= 8 && tzHour <= 18) {
                                        suitableCount++;
                                    }
                                });
                                
                                if (suitableCount >= Math.floor(targetTimezones.length * 0.7)) {
                                    suggestions.push(`${hour}:00 ${sourceTimezone.split('/')[1]} time`);
                                }
                            });
                            
                            return suggestions.length > 0 ? suggestions : ['No ideal time found for all zones'];
                        }

                        function convert() {
                            try {
                                // Get source date and time
                                const dateStr = sourceDate.value;
                                const timeStr = sourceTime.value;
                                const sourceTz = sourceTimezone.value;
                                
                                if (!dateStr || !timeStr) {
                                    return;
                                }
                                
                                // Create source date
                                const sourceDateTime = new Date(`${dateStr}T${timeStr}`);
                                
                                // Update source display
                                const sourceFormatted = formatDateTimeForTimezone(sourceDateTime, sourceTz);
                                const sourceAbbr = getTimezoneAbbreviation(sourceDateTime, sourceTz);
                                sourceDisplay.textContent = `${sourceFormatted} ${sourceAbbr}`;
                                sourceDescription.textContent = sourceTz.replace('_', ' ');
                                
                                // Get selected target time zones
                                const selectedTimezones = Array.from(targetTimezoneCheckboxes)
                                    .filter(cb => cb.checked)
                                    .map(cb => cb.value);
                                
                                // Clear previous results
                                targetTimezones.innerHTML = '';
                                timeDifferences.innerHTML = '';
                                dstInfo.innerHTML = '';
                                
                                if (selectedTimezones.length === 0) {
                                    targetTimezones.innerHTML = '<div class="text-center text-gray-500 py-4">Select target time zones to see conversions</div>';
                                    return;
                                }
                                
                                // Convert to each target timezone
                                selectedTimezones.forEach((tz, index) => {
                                    const targetFormatted = formatDateTimeForTimezone(sourceDateTime, tz);
                                    const targetAbbr = getTimezoneAbbreviation(sourceDateTime, tz);
                                    const offset = getTimezoneOffset(sourceDateTime, tz);
                                    const isDstActive = isDST(sourceDateTime, tz);
                                    
                                    // Create target timezone card
                                    const card = document.createElement('div');
                                    card.className = `p-4 bg-gradient-to-r ${getCardColor(index)} rounded-lg border-l-4 ${getBorderColor(index)}`;
                                    card.innerHTML = `
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h5 class="text-sm font-semibold text-gray-700 mb-1">${tz.replace('_', ' ')}</h5>
                                                <div class="text-lg font-bold ${getTextColor(index)} font-mono">${targetFormatted}</div>
                                                <div class="text-xs text-gray-500 mt-1">${targetAbbr}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-mono text-gray-600">${offset}</div>
                                                ${isDstActive ? '<div class="text-xs text-blue-600">DST</div>' : ''}
                                            </div>
                                        </div>
                                    `;
                                    targetTimezones.appendChild(card);
                                    
                                    // Add time difference
                                    const diffElement = document.createElement('div');
                                    diffElement.className = 'flex justify-between text-sm';
                                    diffElement.innerHTML = `
                                        <span>${tz.split('/')[1]}:</span>
                                        <span class="font-mono">${offset} from UTC</span>
                                    `;
                                    timeDifferences.appendChild(diffElement);
                                    
                                    // Add DST info
                                    const dstElement = document.createElement('div');
                                    dstElement.className = 'flex justify-between text-sm';
                                    dstElement.innerHTML = `
                                        <span>${tz.split('/')[1]}:</span>
                                        <span class="${isDstActive ? 'text-blue-600' : 'text-gray-600'}">${isDstActive ? 'DST Active' : 'Standard Time'}</span>
                                    `;
                                    dstInfo.appendChild(dstElement);
                                });
                                
                                // Business hours analysis
                                const businessAnalysis = analyzeBusinessHours(sourceDateTime, sourceTz, selectedTimezones);
                                businessHours.innerHTML = businessAnalysis.join(' • ');
                                
                                // Meeting time suggestions
                                const meetingSuggestions = suggestMeetingTimes(sourceTz, selectedTimezones);
                                meetingTimes.innerHTML = `Best times: ${meetingSuggestions.slice(0, 3).join(', ')}`;
                                
                            } catch (error) {
                                console.error('Conversion error:', error);
                                targetTimezones.innerHTML = '<div class="text-center text-red-500 py-4">Error in time conversion</div>';
                            }
                        }

                        function getCardColor(index) {
                            const colors = [
                                'from-red-50 to-pink-50',
                                'from-blue-50 to-indigo-50',
                                'from-green-50 to-emerald-50',
                                'from-yellow-50 to-amber-50',
                                'from-purple-50 to-violet-50',
                                'from-cyan-50 to-blue-50'
                            ];
                            return colors[index % colors.length];
                        }

                        function getBorderColor(index) {
                            const colors = [
                                'border-red-500',
                                'border-blue-500',
                                'border-green-500',
                                'border-yellow-500',
                                'border-purple-500',
                                'border-cyan-500'
                            ];
                            return colors[index % colors.length];
                        }

                        function getTextColor(index) {
                            const colors = [
                                'text-red-600',
                                'text-blue-600',
                                'text-green-600',
                                'text-yellow-600',
                                'text-purple-600',
                                'text-cyan-600'
                            ];
                            return colors[index % colors.length];
                        }

                        function updateWorldClock() {
                            worldClock.innerHTML = '';
                            const now = new Date();
                            
                            majorTimezones.forEach((tz, index) => {
                                const timeStr = formatDateTimeForTimezone(now, tz.timezone);
                                const abbr = getTimezoneAbbreviation(now, tz.timezone);
                                
                                const card = document.createElement('div');
                                card.className = `p-4 bg-gradient-to-r ${getCardColor(index)} rounded-lg text-center`;
                                card.innerHTML = `
                                    <h5 class="text-sm font-semibold text-gray-700 mb-1">${tz.name}</h5>
                                    <div class="text-lg font-bold ${getTextColor(index)} font-mono">${timeStr}</div>
                                    <div class="text-xs text-gray-500 mt-1">${abbr}</div>
                                `;
                                worldClock.appendChild(card);
                            });
                        }

                        function setCurrentTime() {
                            const now = new Date();
                            sourceDate.value = now.toISOString().split('T')[0];
                            sourceTime.value = now.toTimeString().split(' ')[0];
                            convert();
                        }

                        function selectMajorCities() {
                            const majorCities = ['America/New_York', 'Europe/London', 'Asia/Tokyo', 'Australia/Sydney'];
                            targetTimezoneCheckboxes.forEach(cb => {
                                cb.checked = majorCities.includes(cb.value);
                            });
                            convert();
                        }

                        function clearAllSelections() {
                            targetTimezoneCheckboxes.forEach(cb => {
                                cb.checked = false;
                            });
                            convert();
                        }

                        function clearAll() {
                            sourceDate.value = '2025-07-23';
                            sourceTime.value = '14:46:06';
                            sourceTimezone.value = 'UTC';
                            clearAllSelections();
                        }

                        // Event listeners
                        sourceDate.addEventListener('change', convert);
                        sourceTime.addEventListener('change', convert);
                        sourceTimezone.addEventListener('change', convert);
                        
                        targetTimezoneCheckboxes.forEach(cb => {
                            cb.addEventListener('change', convert);
                        });
                        
                        useCurrentTime.addEventListener('click', setCurrentTime);
                        selectAllMajor.addEventListener('click', selectMajorCities);
                        clearSelections.addEventListener('click', clearAllSelections);
                        clearButton.addEventListener('click', clearAll);

                        // Initialize
                        convert();
                        updateCurrentTime();
                        updateWorldClock();
                        
                        // Update current time and world clock every second
                        updateInterval = setInterval(() => {
                            updateCurrentTime();
                            updateWorldClock();
                        }, 1000);

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
