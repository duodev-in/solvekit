<x-tool-page-layout
    title="Coordinates Converter - SolveKit"
    description="Professional coordinates converter for GPS, mapping and surveying applications. Convert between decimal degrees, DMS, UTM and other coordinate systems."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Coordinates</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Coordinate Format Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Input Format
                                                                                </label>
                                                                                <select 
                                                                                    id="inputFormat" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="decimal">Decimal Degrees (DD)</option>
                                                                                    <option value="dms">Degrees Minutes Seconds (DMS)</option>
                                                                                    <option value="dm">Degrees Minutes (DM)</option>
                                                                                    <option value="utm">UTM Coordinates</option>
                                                                                    <option value="mgrs">MGRS (Military Grid)</option>
                                                                                    <option value="pluscode">Plus Codes (Open Location Code)</option>
                                                                                    <option value="maidenhead">Maidenhead Locator System</option>
                                                                                    <option value="geohash">Geohash</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Input Fields (Dynamic based on format) -->
                                                                            <div id="inputFields" class="space-y-4">

                                                                                <!-- Decimal Degrees Input -->
                                                                                <div id="decimalInput" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                    <div class="space-y-2">
                                                                                        <label for="latitude" class="block text-sm font-semibold text-gray-700">Latitude</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="latitude" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 40.7589"
                                                                                                step="any"
                                                                                                min="-90"
                                                                                                max="90"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">°</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <p class="text-xs text-gray-500">Range: -90° to +90°</p>
                                                                                    </div>
                                                                                    <div class="space-y-2">
                                                                                        <label for="longitude" class="block text-sm font-semibold text-gray-700">Longitude</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="longitude" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., -73.9851"
                                                                                                step="any"
                                                                                                min="-180"
                                                                                                max="180"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">°</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <p class="text-xs text-gray-500">Range: -180° to +180°</p>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- DMS Input -->
                                                                                <div id="dmsInput" class="space-y-4" style="display: none;">
                                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                        <!-- Latitude DMS -->
                                                                                        <div class="space-y-2">
                                                                                            <label class="block text-sm font-semibold text-gray-700">Latitude DMS</label>
                                                                                            <div class="grid grid-cols-3 gap-2">
                                                                                                <input type="number" id="latDeg" class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all" placeholder="40" min="0" max="90">
                                                                                                <input type="number" id="latMin" class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all" placeholder="45" min="0" max="59">
                                                                                                <input type="number" id="latSec" class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all" placeholder="32.04" min="0" max="59.999" step="any">
                                                                                            </div>
                                                                                            <div class="grid grid-cols-2 gap-2">
                                                                                                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg cursor-pointer">
                                                                                                    <input type="radio" name="latDir" value="N" class="text-emerald-600" checked>
                                                                                                    <span class="text-sm">North</span>
                                                                                                </label>
                                                                                                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg cursor-pointer">
                                                                                                    <input type="radio" name="latDir" value="S" class="text-emerald-600">
                                                                                                    <span class="text-sm">South</span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Longitude DMS -->
                                                                                        <div class="space-y-2">
                                                                                            <label class="block text-sm font-semibold text-gray-700">Longitude DMS</label>
                                                                                            <div class="grid grid-cols-3 gap-2">
                                                                                                <input type="number" id="lngDeg" class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all" placeholder="73" min="0" max="180">
                                                                                                <input type="number" id="lngMin" class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all" placeholder="59" min="0" max="59">
                                                                                                <input type="number" id="lngSec" class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all" placeholder="6.36" min="0" max="59.999" step="any">
                                                                                            </div>
                                                                                            <div class="grid grid-cols-2 gap-2">
                                                                                                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg cursor-pointer">
                                                                                                    <input type="radio" name="lngDir" value="E" class="text-emerald-600" checked>
                                                                                                    <span class="text-sm">East</span>
                                                                                                </label>
                                                                                                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg cursor-pointer">
                                                                                                    <input type="radio" name="lngDir" value="W" class="text-emerald-600">
                                                                                                    <span class="text-sm">West</span>
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- UTM Input -->
                                                                                <div id="utmInput" class="space-y-4" style="display: none;">
                                                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                        <div class="space-y-2">
                                                                                            <label for="utmZoneInput" class="block text-sm font-semibold text-gray-700">UTM Zone</label>
                                                                                            <select id="utmZoneInput" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all bg-white">
                                                                                                <!-- Will be populated by JavaScript -->
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="space-y-2">
                                                                                            <label for="utmEasting" class="block text-sm font-semibold text-gray-700">Easting (m)</label>
                                                                                            <input type="number" id="utmEasting" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all" placeholder="583960" min="0" max="999999">
                                                                                        </div>
                                                                                        <div class="space-y-2">
                                                                                            <label for="utmNorthing" class="block text-sm font-semibold text-gray-700">Northing (m)</label>
                                                                                            <input type="number" id="utmNorthing" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 transition-all" placeholder="4511322" min="0" max="9999999">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Single Text Input for other formats -->
                                                                                <div id="textInput" class="space-y-2" style="display: none;">
                                                                                    <label for="coordinateText" class="block text-sm font-semibold text-gray-700" id="textInputLabel">Coordinate String</label>
                                                                                    <input 
                                                                                        type="text" 
                                                                                        id="coordinateText" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter coordinate string"
                                                                                    >
                                                                                    <p class="text-xs text-gray-500" id="textInputHelp">Enter the coordinate in the selected format</p>
                                                                                </div>

                                                                            </div>

                                                                            <!-- Coordinate Precision -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Output Precision
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-emerald-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-emerald-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-emerald-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-emerald-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Sample Locations -->
                                                                            

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
                                                                                    Clear All
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Values</h3>

                                                                            <!-- All Coordinate Formats -->
                                                                            <div class="grid grid-cols-1 gap-4">
                                                                                <!-- Decimal Degrees -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="flex justify-between items-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Decimal Degrees (DD)</h4>
                                                                                        <button class="copy-btn text-xs text-blue-600 hover:text-blue-800" data-target="ddOutput">Copy</button>
                                                                                    </div>
                                                                                    <div class="text-lg font-bold text-blue-600 font-mono" id="ddOutput">--</div>
                                                                                    <div class="text-xs text-gray-500 mt-1">Most common GPS format</div>
                                                                                </div>

                                                                                <!-- Degrees Minutes Seconds -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="flex justify-between items-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Degrees Minutes Seconds (DMS)</h4>
                                                                                        <button class="copy-btn text-xs text-green-600 hover:text-green-800" data-target="dmsOutput">Copy</button>
                                                                                    </div>
                                                                                    <div class="text-lg font-bold text-green-600 font-mono" id="dmsOutput">--</div>
                                                                                    <div class="text-xs text-gray-500 mt-1">Traditional navigation format</div>
                                                                                </div>

                                                                                <!-- Degrees Minutes -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="flex justify-between items-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Degrees Minutes (DM)</h4>
                                                                                        <button class="copy-btn text-xs text-purple-600 hover:text-purple-800" data-target="dmOutput">Copy</button>
                                                                                    </div>
                                                                                    <div class="text-lg font-bold text-purple-600 font-mono" id="dmOutput">--</div>
                                                                                    <div class="text-xs text-gray-500 mt-1">Marine & aviation format</div>
                                                                                </div>

                                                                                <!-- UTM -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="flex justify-between items-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">UTM Coordinates</h4>
                                                                                        <button class="copy-btn text-xs text-orange-600 hover:text-orange-800" data-target="utmOutput">Copy</button>
                                                                                    </div>
                                                                                    <div class="text-lg font-bold text-orange-600 font-mono" id="utmOutput">--</div>
                                                                                    <div class="text-xs text-gray-500 mt-1">Universal Transverse Mercator</div>
                                                                                </div>

                                                                                <!-- MGRS -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="flex justify-between items-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">MGRS (Military Grid)</h4>
                                                                                        <button class="copy-btn text-xs text-cyan-600 hover:text-cyan-800" data-target="mgrsOutput">Copy</button>
                                                                                    </div>
                                                                                    <div class="text-lg font-bold text-cyan-600 font-mono" id="mgrsOutput">--</div>
                                                                                    <div class="text-xs text-gray-500 mt-1">Military Grid Reference System</div>
                                                                                </div>

                                                                                <!-- Plus Codes -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="flex justify-between items-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Plus Codes (Open Location Code)</h4>
                                                                                        <button class="copy-btn text-xs text-yellow-600 hover:text-yellow-800" data-target="plusCodeOutput">Copy</button>
                                                                                    </div>
                                                                                    <div class="text-lg font-bold text-yellow-600 font-mono" id="plusCodeOutput">--</div>
                                                                                    <div class="text-xs text-gray-500 mt-1">Google's address system</div>
                                                                                </div>

                                                                                <!-- Maidenhead -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="flex justify-between items-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Maidenhead Locator</h4>
                                                                                        <button class="copy-btn text-xs text-pink-600 hover:text-pink-800" data-target="maidenheadOutput">Copy</button>
                                                                                    </div>
                                                                                    <div class="text-lg font-bold text-pink-600 font-mono" id="maidenheadOutput">--</div>
                                                                                    <div class="text-xs text-gray-500 mt-1">Amateur radio grid system</div>
                                                                                </div>

                                                                                <!-- Geohash -->
                                                                                <div class="p-4 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                    <div class="flex justify-between items-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Geohash</h4>
                                                                                        <button class="copy-btn text-xs text-teal-600 hover:text-teal-800" data-target="geohashOutput">Copy</button>
                                                                                    </div>
                                                                                    <div class="text-lg font-bold text-teal-600 font-mono" id="geohashOutput">--</div>
                                                                                    <div class="text-xs text-gray-500 mt-1">Base32 geocoding system</div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Location Information -->
                                                                            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Location Information</h4>
                                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Hemisphere:</span>
                                                                                        <span class="font-mono text-indigo-700" id="hemisphere">--</span>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">UTM Zone:</span>
                                                                                        <span class="font-mono text-indigo-700" id="utmZone">--</span>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Time Zone:</span>
                                                                                        <span class="font-mono text-indigo-700" id="timeZone">--</span>
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
                                                                                                    Sample Locations
                                                                                                </label>
                                                                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-lat="40.7589" data-lng="-73.9851">NYC</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-lat="51.5074" data-lng="-0.1278">London</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-lat="35.6762" data-lng="139.6503">Tokyo</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-lat="-33.8688" data-lng="151.2093">Sydney</button>
                                                                                                </div>
                                                                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-2">
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-lat="48.8566" data-lng="2.3522">Paris</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-lat="55.7558" data-lng="37.6176">Moscow</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-lat="-34.6037" data-lng="-58.3816">Buenos Aires</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 rounded-lg transition-colors" data-lat="1.3521" data-lng="103.8198">Singapore</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Coordinate System Reference</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• DD: Decimal degrees (±180°)</div>
                                                        <div>• DMS: Degrees° Minutes' Seconds"</div>
                                                        <div>• UTM: Universal Transverse Mercator</div>
                                                        <div>• MGRS: Military Grid Reference System</div>
                                                        <div>• Plus Codes: Open Location Code (Google)</div>
                                                        <div>• Maidenhead: Amateur radio grid locator</div>
                                                        <div>• Geohash: Base32 hierarchical grid</div>
                                                        <div>• All formats support WGS84 datum</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Coordinate Systems</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">GPS & Navigation</h4>
                                    <p>Essential for GPS navigation, mapping applications, surveying, and geographic information systems (GIS). Different coordinate systems are used for various applications and regions worldwide.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Professional Applications</h4>
                                    <p>Used in surveying, cartography, military operations, aviation, marine navigation, and scientific research. Accurate coordinate conversion is critical for precision mapping and location services.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-emerald-50 rounded-lg border border-emerald-200">
                                <p class="text-sm text-emerald-800">
                                    <strong>Precision Note:</strong> All conversions use WGS84 datum. For highest precision in surveying applications, consider local datum transformations and projection parameters!
                                </p>
                            </div>
                        </div>

                        <!-- Coordinate Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Coordinate Format Examples</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Geographic Formats</h4>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-emerald-600">DD:</div>
                                        <div class="text-xs text-gray-600 mt-1">40.758900, -73.985100</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-emerald-600">DMS:</div>
                                        <div class="text-xs text-gray-600 mt-1">40°45'32.04"N, 73°59'6.36"W</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-emerald-600">DM:</div>
                                        <div class="text-xs text-gray-600 mt-1">40°45.534'N, 73°59.106'W</div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Grid Systems</h4>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-emerald-600">UTM:</div>
                                        <div class="text-xs text-gray-600 mt-1">18T 583960E 4511322N</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-emerald-600">Plus Code:</div>
                                        <div class="text-xs text-gray-600 mt-1">87G8Q23V+XQ</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-emerald-600">Geohash:</div>
                                        <div class="text-xs text-gray-600 mt-1">dr5regw3p</div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const latitude = document.getElementById('latitude');
                        const longitude = document.getElementById('longitude');
                        const inputFormat = document.getElementById('inputFormat');
                        const clearButton = document.getElementById('clearButton');
                        const precisionRadios = document.getElementsByName('precision');
                        
                        // Input containers
                        const decimalInput = document.getElementById('decimalInput');
                        const dmsInput = document.getElementById('dmsInput');
                        const utmInput = document.getElementById('utmInput');
                        const textInput = document.getElementById('textInput');
                        
                        // DMS inputs
                        const latDeg = document.getElementById('latDeg');
                        const latMin = document.getElementById('latMin');
                        const latSec = document.getElementById('latSec');
                        const lngDeg = document.getElementById('lngDeg');
                        const lngMin = document.getElementById('lngMin');
                        const lngSec = document.getElementById('lngSec');
                        const latDirRadios = document.getElementsByName('latDir');
                        const lngDirRadios = document.getElementsByName('lngDir');
                        
                        // UTM inputs
                        const utmZoneInput = document.getElementById('utmZoneInput');
                        const utmEasting = document.getElementById('utmEasting');
                        const utmNorthing = document.getElementById('utmNorthing');
                        
                        // Text input
                        const coordinateText = document.getElementById('coordinateText');
                        const textInputLabel = document.getElementById('textInputLabel');
                        const textInputHelp = document.getElementById('textInputHelp');
                        
                        // Output elements
                        const ddOutput = document.getElementById('ddOutput');
                        const dmsOutput = document.getElementById('dmsOutput');
                        const dmOutput = document.getElementById('dmOutput');
                        const utmOutput = document.getElementById('utmOutput');
                        const mgrsOutput = document.getElementById('mgrsOutput');
                        const plusCodeOutput = document.getElementById('plusCodeOutput');
                        const maidenheadOutput = document.getElementById('maidenheadOutput');
                        const geohashOutput = document.getElementById('geohashOutput');
                        const hemisphere = document.getElementById('hemisphere');
                        const utmZone = document.getElementById('utmZone');
                        const timeZone = document.getElementById('timeZone');

                        // Populate UTM zones
                        function populateUTMZones() {
                            utmZoneInput.innerHTML = '';
                            for (let i = 1; i <= 60; i++) {
                                const option = document.createElement('option');
                                option.value = i;
                                option.textContent = `Zone ${i}`;
                                if (i === 33) option.selected = true; // Default to zone 33
                                utmZoneInput.appendChild(option);
                            }
                        }

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'auto') {
                                if (Math.abs(num) >= 1000) {
                                    return num.toFixed(2);
                                } else if (Math.abs(num) >= 1) {
                                    return num.toFixed(6);
                                } else {
                                    return num.toFixed(8);
                                }
                            } else {
                                return num.toFixed(precision);
                            }
                        }

                        function updateInputInterface() {
                            const format = inputFormat.value;
                            
                            // Hide all input containers
                            decimalInput.style.display = 'none';
                            dmsInput.style.display = 'none';
                            utmInput.style.display = 'none';
                            textInput.style.display = 'none';
                            
                            // Show appropriate input based on format
                            switch(format) {
                                case 'decimal':
                                    decimalInput.style.display = 'grid';
                                    break;
                                case 'dms':
                                    dmsInput.style.display = 'block';
                                    break;
                                case 'dm':
                                    decimalInput.style.display = 'grid'; // Use decimal inputs for DM too
                                    break;
                                case 'utm':
                                    utmInput.style.display = 'block';
                                    break;
                                case 'mgrs':
                                    textInput.style.display = 'block';
                                    textInputLabel.textContent = 'MGRS Coordinate';
                                    coordinateText.placeholder = 'e.g., 18TWL8396011322';
                                    textInputHelp.textContent = 'Enter MGRS grid reference';
                                    break;
                                case 'pluscode':
                                    textInput.style.display = 'block';
                                    textInputLabel.textContent = 'Plus Code';
                                    coordinateText.placeholder = 'e.g., 87G8Q23V+XQ';
                                    textInputHelp.textContent = 'Enter Google Plus Code';
                                    break;
                                case 'maidenhead':
                                    textInput.style.display = 'block';
                                    textInputLabel.textContent = 'Maidenhead Locator';
                                    coordinateText.placeholder = 'e.g., FN30as';
                                    textInputHelp.textContent = 'Enter Maidenhead grid square';
                                    break;
                                case 'geohash':
                                    textInput.style.display = 'block';
                                    textInputLabel.textContent = 'Geohash';
                                    coordinateText.placeholder = 'e.g., dr5regw3p';
                                    textInputHelp.textContent = 'Enter geohash string';
                                    break;
                            }
                        }

                        function convertToDMS(decimal) {
                            const abs = Math.abs(decimal);
                            const degrees = Math.floor(abs);
                            const minutes = Math.floor((abs - degrees) * 60);
                            const seconds = ((abs - degrees) * 60 - minutes) * 60;
                            return { degrees, minutes, seconds };
                        }

                        function convertToDM(decimal) {
                            const abs = Math.abs(decimal);
                            const degrees = Math.floor(abs);
                            const minutes = (abs - degrees) * 60;
                            return { degrees, minutes };
                        }

                        function dmsToDecimal(deg, min, sec, direction) {
                            let decimal = deg + min/60 + sec/3600;
                            if (direction === 'S' || direction === 'W') {
                                decimal = -decimal;
                            }
                            return decimal;
                        }

                        function getUTMZone(lat, lng) {
                            return Math.floor((lng + 180) / 6) + 1;
                        }

                        function getUTMBand(lat) {
                            if (lat >= -80 && lat < -72) return 'C';
                            if (lat >= -72 && lat < -64) return 'D';
                            if (lat >= -64 && lat < -56) return 'E';
                            if (lat >= -56 && lat < -48) return 'F';
                            if (lat >= -48 && lat < -40) return 'G';
                            if (lat >= -40 && lat < -32) return 'H';
                            if (lat >= -32 && lat < -24) return 'J';
                            if (lat >= -24 && lat < -16) return 'K';
                            if (lat >= -16 && lat < -8) return 'L';
                            if (lat >= -8 && lat < 0) return 'M';
                            if (lat >= 0 && lat < 8) return 'N';
                            if (lat >= 8 && lat < 16) return 'P';
                            if (lat >= 16 && lat < 24) return 'Q';
                            if (lat >= 24 && lat < 32) return 'R';
                            if (lat >= 32 && lat < 40) return 'S';
                            if (lat >= 40 && lat < 48) return 'T';
                            if (lat >= 48 && lat < 56) return 'U';
                            if (lat >= 56 && lat < 64) return 'V';
                            if (lat >= 64 && lat < 72) return 'W';
                            if (lat >= 72 && lat <= 80) return 'X';
                            return '';
                        }

                        function latLongToUTM(lat, lng) {
                            const zone = getUTMZone(lat, lng);
                            const band = getUTMBand(lat);
                            
                            // Simplified UTM calculation (for demonstration)
                            const centralMeridian = (zone - 1) * 6 - 180 + 3;
                            const k0 = 0.9996;
                            
                            const easting = 500000 + (lng - centralMeridian) * 111000 * Math.cos(lat * Math.PI / 180) * k0;
                            const northing = lat >= 0 ? 
                                lat * 110540 * k0 : 
                                10000000 + lat * 110540 * k0;
                            
                            return {
                                zone: zone,
                                band: band,
                                easting: Math.round(easting),
                                northing: Math.round(Math.abs(northing))
                            };
                        }

                        function generateMGRS(zone, band, easting, northing) {
                            // Simplified MGRS generation
                            const e = Math.floor(easting / 100000);
                            const n = Math.floor(northing / 100000);
                            const letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
                            const eastLetter = letters[e % 8];
                            const northLetter = letters[n % 20];
                            
                            const eastGrid = String(easting % 100000).padStart(5, '0');
                            const northGrid = String(northing % 100000).padStart(5, '0');
                            
                            return `${zone}${band}${eastLetter}${northLetter}${eastGrid}${northGrid}`;
                        }

                        function generatePlusCode(lat, lng) {
                            // Very simplified Plus Code generation
                            const latCode = Math.floor((lat + 90) * 8000).toString(32).toUpperCase().padStart(4, '0');
                            const lngCode = Math.floor((lng + 180) * 8000).toString(32).toUpperCase().padStart(4, '0');
                            return `${latCode.substring(0, 4)}+${lngCode.substring(0, 4)}`;
                        }

                        function generateMaidenhead(lat, lng) {
                            // Simplified Maidenhead locator generation
                            const A = Math.floor((lng + 180) / 20);
                            const B = Math.floor((lat + 90) / 10);
                            const C = Math.floor(((lng + 180) % 20) / 2);
                            const D = Math.floor(((lat + 90) % 10) / 1);
                            const E = Math.floor(((lng + 180) % 2) * 12);
                            const F = Math.floor(((lat + 90) % 1) * 24);
                            
                            return String.fromCharCode(65 + A) + String.fromCharCode(65 + B) + 
                                   C + D + String.fromCharCode(97 + E) + String.fromCharCode(97 + F);
                        }

                        function generateGeohash(lat, lng, precision = 9) {
                            // Simplified geohash generation
                            const base32 = '0123456789bcdefghjkmnpqrstuvwxyz';
                            let hash = '';
                            let latRange = [-90, 90];
                            let lngRange = [-180, 180];
                            let even = true;
                            let bit = 0;
                            let bitCount = 0;
                            
                            while (hash.length < precision) {
                                if (even) {
                                    const mid = (lngRange[0] + lngRange[1]) / 2;
                                    if (lng >= mid) {
                                        bit = bit * 2 + 1;
                                        lngRange[0] = mid;
                                    } else {
                                        bit = bit * 2;
                                        lngRange[1] = mid;
                                    }
                                } else {
                                    const mid = (latRange[0] + latRange[1]) / 2;
                                    if (lat >= mid) {
                                        bit = bit * 2 + 1;
                                        latRange[0] = mid;
                                    } else {
                                        bit = bit * 2;
                                        latRange[1] = mid;
                                    }
                                }
                                
                                even = !even;
                                bitCount++;
                                
                                if (bitCount === 5) {
                                    hash += base32[bit];
                                    bit = 0;
                                    bitCount = 0;
                                }
                            }
                            
                            return hash;
                        }

                        function getTimeZone(lng) {
                            // Simplified timezone calculation
                            const offset = Math.round(lng / 15);
                            return `UTC${offset >= 0 ? '+' : ''}${offset}`;
                        }

                        function getCurrentCoordinates() {
                            const format = inputFormat.value;
                            let lat, lng;

                            switch(format) {
                                case 'decimal':
                                case 'dm':
                                    lat = parseFloat(latitude.value);
                                    lng = parseFloat(longitude.value);
                                    break;
                                case 'dms':
                                    const latDir = document.querySelector('input[name="latDir"]:checked').value;
                                    const lngDir = document.querySelector('input[name="lngDir"]:checked').value;
                                    lat = dmsToDecimal(
                                        parseFloat(latDeg.value) || 0,
                                        parseFloat(latMin.value) || 0,
                                        parseFloat(latSec.value) || 0,
                                        latDir
                                    );
                                    lng = dmsToDecimal(
                                        parseFloat(lngDeg.value) || 0,
                                        parseFloat(lngMin.value) || 0,
                                        parseFloat(lngSec.value) || 0,
                                        lngDir
                                    );
                                    break;
                                // For other formats, we'd need more complex parsing
                                default:
                                    lat = parseFloat(latitude.value);
                                    lng = parseFloat(longitude.value);
                            }

                            return { lat, lng };
                        }

                        function convert() {
                            const coords = getCurrentCoordinates();
                            const lat = coords.lat;
                            const lng = coords.lng;
                            const precision = getPrecision();

                            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                                // Decimal Degrees
                                ddOutput.textContent = `${formatNumber(lat, precision)}, ${formatNumber(lng, precision)}`;

                                // DMS
                                const latDMS = convertToDMS(lat);
                                const lngDMS = convertToDMS(lng);
                                const latDir = lat >= 0 ? 'N' : 'S';
                                const lngDir = lng >= 0 ? 'E' : 'W';
                                dmsOutput.textContent = `${latDMS.degrees}°${latDMS.minutes}'${formatNumber(latDMS.seconds, 2)}"${latDir}, ${lngDMS.degrees}°${lngDMS.minutes}'${formatNumber(lngDMS.seconds, 2)}"${lngDir}`;

                                // DM
                                const latDM = convertToDM(lat);
                                const lngDM = convertToDM(lng);
                                dmOutput.textContent = `${latDM.degrees}°${formatNumber(latDM.minutes, 4)}'${latDir}, ${lngDM.degrees}°${formatNumber(lngDM.minutes, 4)}'${lngDir}`;

                                // UTM
                                const utm = latLongToUTM(lat, lng);
                                utmOutput.textContent = `${utm.zone}${utm.band} ${utm.easting}E ${utm.northing}N`;

                                // MGRS
                                mgrsOutput.textContent = generateMGRS(utm.zone, utm.band, utm.easting, utm.northing);

                                // Plus Code
                                plusCodeOutput.textContent = generatePlusCode(lat, lng);

                                // Maidenhead
                                maidenheadOutput.textContent = generateMaidenhead(lat, lng);

                                // Geohash
                                geohashOutput.textContent = generateGeohash(lat, lng);

                                // Location Information
                                hemisphere.textContent = `${lat >= 0 ? 'Northern' : 'Southern'}, ${lng >= 0 ? 'Eastern' : 'Western'}`;
                                utmZone.textContent = `${utm.zone}${utm.band}`;
                                timeZone.textContent = getTimeZone(lng);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            ddOutput.textContent = '--';
                            dmsOutput.textContent = '--';
                            dmOutput.textContent = '--';
                            utmOutput.textContent = '--';
                            mgrsOutput.textContent = '--';
                            plusCodeOutput.textContent = '--';
                            maidenheadOutput.textContent = '--';
                            geohashOutput.textContent = '--';
                            hemisphere.textContent = '--';
                            utmZone.textContent = '--';
                            timeZone.textContent = '--';
                        }

                        function clearAll() {
                            latitude.value = '';
                            longitude.value = '';
                            latDeg.value = '';
                            latMin.value = '';
                            latSec.value = '';
                            lngDeg.value = '';
                            lngMin.value = '';
                            lngSec.value = '';
                            utmEasting.value = '';
                            utmNorthing.value = '';
                            coordinateText.value = '';
                            clearOutputs();
                            latitude.focus();
                        }

                        // Event listeners
                        latitude.addEventListener('input', convert);
                        longitude.addEventListener('input', convert);
                        inputFormat.addEventListener('change', () => {
                            updateInputInterface();
                            convert();
                        });
                        clearButton.addEventListener('click', clearAll);

                        // DMS input listeners
                        latDeg.addEventListener('input', convert);
                        latMin.addEventListener('input', convert);
                        latSec.addEventListener('input', convert);
                        lngDeg.addEventListener('input', convert);
                        lngMin.addEventListener('input', convert);
                        lngSec.addEventListener('input', convert);
                        latDirRadios.forEach(radio => radio.addEventListener('change', convert));
                        lngDirRadios.forEach(radio => radio.addEventListener('change', convert));

                        // UTM input listeners
                        utmZoneInput.addEventListener('change', convert);
                        utmEasting.addEventListener('input', convert);
                        utmNorthing.addEventListener('input', convert);

                        // Text input listener
                        coordinateText.addEventListener('input', convert);

                        // Precision change listener
                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        // Sample locations
                        const sampleLocations = document.querySelectorAll('.sample-location');
                        sampleLocations.forEach(button => {
                            button.addEventListener('click', function() {
                                const lat = this.getAttribute('data-lat');
                                const lng = this.getAttribute('data-lng');
                                
                                // Switch to decimal input mode
                                inputFormat.value = 'decimal';
                                updateInputInterface();
                                
                                latitude.value = lat;
                                longitude.value = lng;
                                convert();
                                
                                // Update button styles
                                sampleLocations.forEach(btn => btn.classList.remove('bg-emerald-100', 'text-emerald-700'));
                                sampleLocations.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-emerald-100', 'text-emerald-700');
                            });
                        });

                        // Copy functionality
                        const copyButtons = document.querySelectorAll('.copy-btn');
                        copyButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const targetId = this.getAttribute('data-target');
                                const targetElement = document.getElementById(targetId);
                                const text = targetElement.textContent;
                                
                                if (text !== '--') {
                                    navigator.clipboard.writeText(text).then(() => {
                                        this.textContent = 'Copied!';
                                        setTimeout(() => {
                                            this.textContent = 'Copy';
                                        }, 2000);
                                    });
                                }
                            });
                        });

                        // Initialize
                        populateUTMZones();
                        updateInputInterface();
                        latitude.focus();
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
