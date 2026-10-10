<x-tool-page-layout
    title="Lat Long to UTM Converter - ConvertPro"
    description="Professional latitude longitude to UTM converter for surveying and mapping. Convert between geographic and UTM coordinate systems with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Lat/Long to UTM</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Mode -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Mode
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer bg-red-50 border-red-300">
                                                                                        <input type="radio" name="mode" value="latlong-to-utm" class="text-red-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Lat/Long → UTM</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="utm-to-latlong" class="text-red-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">UTM → Lat/Long</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Lat/Long Input -->
                                                                            <div id="latlongInput" class="space-y-4">
                                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                                                            </div>

                                                                            <!-- UTM Input -->
                                                                            <div id="utmInput" class="space-y-4" style="display: none;">
                                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                    <div class="space-y-2">
                                                                                        <label for="utmZone" class="block text-sm font-semibold text-gray-700">UTM Zone</label>
                                                                                        <select 
                                                                                            id="utmZone" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                        >
                                                                                            <!-- Will be populated by JavaScript -->
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="space-y-2">
                                                                                        <label for="utmEasting" class="block text-sm font-semibold text-gray-700">Easting</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="utmEasting" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 583960"
                                                                                                step="any"
                                                                                                min="0"
                                                                                                max="999999"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">m</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="space-y-2">
                                                                                        <label for="utmNorthing" class="block text-sm font-semibold text-gray-700">Northing</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="utmNorthing" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 4511322"
                                                                                                step="any"
                                                                                                min="0"
                                                                                                max="9999999"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">m</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Hemisphere -->
                                                                                <div class="space-y-2">
                                                                                    <label class="block text-sm font-semibold text-gray-700">Hemisphere</label>
                                                                                    <div class="grid grid-cols-2 gap-2">
                                                                                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                            <input type="radio" name="hemisphere" value="N" class="text-red-600 focus:ring-slate-200" checked>
                                                                                            <span class="text-sm font-medium">Northern</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                            <input type="radio" name="hemisphere" value="S" class="text-red-600 focus:ring-slate-200">
                                                                                            <span class="text-sm font-medium">Southern</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Datum Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="datum" class="block text-sm font-semibold text-gray-700">
                                                                                    Datum / Ellipsoid
                                                                                </label>
                                                                                <select 
                                                                                    id="datum" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="WGS84" selected>WGS84 (World Geodetic System 1984)</option>
                                                                                    <option value="NAD83">NAD83 (North American Datum 1983)</option>
                                                                                    <option value="NAD27">NAD27 (North American Datum 1927)</option>
                                                                                    <option value="GRS80">GRS80 (Geodetic Reference System 1980)</option>
                                                                                    <option value="Clarke1866">Clarke 1866</option>
                                                                                    <option value="Bessel1841">Bessel 1841</option>
                                                                                    <option value="Airy1830">Airy 1830</option>
                                                                                    <option value="International1924">International 1924</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Precision Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Coordinate Precision
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="0" class="text-red-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Whole</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-red-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-red-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-red-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-red-600 focus:ring-slate-200">
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
                                                                                    class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-lg transition-colors duration-200"
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

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border-l-4 border-red-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">UTM Coordinates</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Universal Transverse Mercator</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-xl font-bold text-red-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-red-600 hover:text-red-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Coordinate Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Geographic Coordinates -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Geographic (Lat/Long)</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="latlongDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Decimal Degrees</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- UTM Coordinates -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">UTM Coordinates</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="utmDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Universal Transverse Mercator</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Formats -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- DMS Format -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">DMS Format</h4>
                                                                                        <div class="text-sm font-bold text-purple-600 font-mono" id="dmsDisplay">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- MGRS -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">MGRS</h4>
                                                                                        <div class="text-sm font-bold text-orange-600 font-mono" id="mgrsDisplay">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Plus Codes -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Plus Codes</h4>
                                                                                        <div class="text-sm font-bold text-cyan-600 font-mono" id="plusCodeDisplay">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Coordinate Information -->
                                                                            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Coordinate Information</h4>
                                                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                                                    <div>
                                                                                        <span class="text-gray-600">Zone:</span>
                                                                                        <span class="font-mono text-indigo-700" id="zoneInfo">--</span>
                                                                                    </div>
                                                                                    <div>
                                                                                        <span class="text-gray-600">Band:</span>
                                                                                        <span class="font-mono text-indigo-700" id="bandInfo">--</span>
                                                                                    </div>
                                                                                    <div>
                                                                                        <span class="text-gray-600">Hemisphere:</span>
                                                                                        <span class="font-mono text-indigo-700" id="hemisphereInfo">--</span>
                                                                                    </div>
                                                                                    <div>
                                                                                        <span class="text-gray-600">Datum:</span>
                                                                                        <span class="font-mono text-indigo-700" id="datumInfo">WGS84</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Coordinate Details -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Central Meridian -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Central Meridian</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="centralMeridian">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Zone center longitude</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Scale Factor -->
                                                                                <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Scale Factor</h4>
                                                                                        <div class="text-lg font-bold text-pink-600 font-mono" id="scaleFactor">0.9996</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">UTM grid scale</div>
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
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-lat="40.7589" data-lng="-73.9851">NYC</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-lat="34.0522" data-lng="-118.2437">LA</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-lat="51.5074" data-lng="-0.1278">London</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-lat="35.6762" data-lng="139.6503">Tokyo</button>
                                                                                                </div>
                                                                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-2">
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-lat="-33.8688" data-lng="151.2093">Sydney</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-lat="48.8566" data-lng="2.3522">Paris</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-lat="55.7558" data-lng="37.6176">Moscow</button>
                                                                                                    <button type="button" class="sample-location px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-lat="-34.6037" data-lng="-58.3816">Buenos Aires</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">UTM System Reference</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• UTM divides Earth into 60 zones (6° each)</div>
                                                        <div>• Each zone uses Transverse Mercator projection</div>
                                                        <div>• Easting: distance east from central meridian</div>
                                                        <div>• Northing: distance north from equator</div>
                                                        <div>• False Easting: 500,000m at central meridian</div>
                                                        <div>• False Northing: 10,000,000m for southern hemisphere</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About UTM Coordinate System</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Surveying & Mapping</h4>
                                    <p>UTM (Universal Transverse Mercator) is widely used in surveying, military mapping, and GPS systems. It provides accurate distance and area measurements over large regions with minimal distortion.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Professional Applications</h4>
                                    <p>Essential for GIS applications, land surveying, military operations, search and rescue, and any application requiring precise rectangular grid coordinates with known scale factors.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-200">
                                <p class="text-sm text-red-800">
                                    <strong>Accuracy Note:</strong> This calculator uses simplified formulas for demonstration. For high-precision surveying work, use professional geodetic software with complete ellipsoid calculations!
                                </p>
                            </div>
                        </div>

                        <!-- Coordinate System Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Coordinate System Examples</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Geographic Coordinates</h4>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-red-600">Decimal Degrees:</div>
                                        <div class="text-xs text-gray-600 mt-1">40.7589°N, 73.9851°W</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-red-600">DMS Format:</div>
                                        <div class="text-xs text-gray-600 mt-1">40°45'32.04"N, 73°59'6.36"W</div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">UTM Examples</h4>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-red-600">UTM Coordinates:</div>
                                        <div class="text-xs text-gray-600 mt-1">18T 583960E 4511322N</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-red-600">MGRS Reference:</div>
                                        <div class="text-xs text-gray-600 mt-1">18TWL8396011322</div>
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
                        const utmZone = document.getElementById('utmZone');
                        const utmEasting = document.getElementById('utmEasting');
                        const utmNorthing = document.getElementById('utmNorthing');
                        const datum = document.getElementById('datum');
                        const modeRadios = document.getElementsByName('mode');
                        const hemisphereRadios = document.getElementsByName('hemisphere');
                        const precisionRadios = document.getElementsByName('precision');
                        const clearButton = document.getElementById('clearButton');
                        const latlongInput = document.getElementById('latlongInput');
                        const utmInput = document.getElementById('utmInput');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const latlongDisplay = document.getElementById('latlongDisplay');
                        const utmDisplay = document.getElementById('utmDisplay');
                        const dmsDisplay = document.getElementById('dmsDisplay');
                        const mgrsDisplay = document.getElementById('mgrsDisplay');
                        const plusCodeDisplay = document.getElementById('plusCodeDisplay');
                        const zoneInfo = document.getElementById('zoneInfo');
                        const bandInfo = document.getElementById('bandInfo');
                        const hemisphereInfo = document.getElementById('hemisphereInfo');
                        const datumInfo = document.getElementById('datumInfo');
                        const centralMeridian = document.getElementById('centralMeridian');
                        const scaleFactor = document.getElementById('scaleFactor');
                        const copyResult = document.getElementById('copyResult');

                        // Populate UTM zones
                        function populateUTMZones() {
                            utmZone.innerHTML = '';
                            for (let i = 1; i <= 60; i++) {
                                const option = document.createElement('option');
                                option.value = i;
                                option.textContent = `Zone ${i}`;
                                if (i === 33) option.selected = true; // Default to zone 33
                                utmZone.appendChild(option);
                            }
                        }

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'auto') {
                                if (num >= 1000000) {
                                    return num.toFixed(0);
                                } else if (num >= 1000) {
                                    return num.toFixed(1);
                                } else if (num >= 1) {
                                    return num.toFixed(6);
                                } else {
                                    return num.toFixed(8);
                                }
                            } else {
                                return num.toFixed(precision);
                            }
                        }

                        function getUTMZone(lat, lng) {
                            let zone = Math.floor((lng + 180) / 6) + 1;
                            // Special cases for Norway and Svalbard
                            if (lng >= 3 && lng < 12 && lat >= 56 && lat <= 64) zone = 32;
                            return zone;
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

                        function convertToDMS(decimal) {
                            const abs = Math.abs(decimal);
                            const degrees = Math.floor(abs);
                            const minutes = Math.floor((abs - degrees) * 60);
                            const seconds = ((abs - degrees) * 60 - minutes) * 60;
                            return { degrees, minutes, seconds };
                        }

                        function latLongToUTM(lat, lng) {
                            const zone = getUTMZone(lat, lng);
                            const band = getUTMBand(lat);
                            
                            // Simplified UTM calculation
                            const centralMeridianCalc = (zone - 1) * 6 - 180 + 3;
                            const k0 = 0.9996; // UTM scale factor
                            
                            // Convert to radians
                            const latRad = lat * Math.PI / 180;
                            const lngRad = lng * Math.PI / 180;
                            const centralMeridianRad = centralMeridianCalc * Math.PI / 180;
                            
                            // Simplified UTM projection (not accurate for precision work)
                            const deltaLng = lngRad - centralMeridianRad;
                            
                            const easting = 500000 + k0 * 6378137 * deltaLng * Math.cos(latRad);
                            const northing = lat >= 0 ? 
                                k0 * 6378137 * latRad : 
                                10000000 + k0 * 6378137 * latRad;
                            
                            return {
                                zone: zone,
                                band: band,
                                easting: Math.round(easting),
                                northing: Math.round(Math.abs(northing)),
                                hemisphere: lat >= 0 ? 'N' : 'S',
                                centralMeridian: centralMeridianCalc
                            };
                        }

                        function utmToLatLong(zone, easting, northing, hemisphere) {
                            const centralMeridianCalc = (zone - 1) * 6 - 180 + 3;
                            const k0 = 0.9996;
                            
                            // Simplified reverse calculation
                            const adjustedNorthing = hemisphere === 'S' ? northing - 10000000 : northing;
                            const lat = adjustedNorthing / (k0 * 6378137) * 180 / Math.PI;
                            const lng = centralMeridianCalc + (easting - 500000) / (k0 * 6378137 * Math.cos(lat * Math.PI / 180)) * 180 / Math.PI;
                            
                            return { lat: lat, lng: lng, centralMeridian: centralMeridianCalc };
                        }

                        function generateMGRS(zone, band, easting, northing) {
                            // Simplified MGRS generation
                            const e100k = Math.floor(easting / 100000);
                            const n100k = Math.floor(northing / 100000);
                            
                            const letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
                            const eastLetter = letters[e100k % 8];
                            const northLetter = letters[n100k % 20];
                            
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

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function getHemisphere() {
                            return document.querySelector('input[name="hemisphere"]:checked').value;
                        }

                        function updateInterface() {
                            const mode = getMode();
                            if (mode === 'latlong-to-utm') {
                                latlongInput.style.display = 'block';
                                utmInput.style.display = 'none';
                                resultTitle.textContent = 'UTM Coordinates';
                                resultDescription.textContent = 'Universal Transverse Mercator';
                            } else {
                                latlongInput.style.display = 'none';
                                utmInput.style.display = 'block';
                                resultTitle.textContent = 'Geographic Coordinates';
                                resultDescription.textContent = 'Latitude / Longitude';
                            }
                        }

                        function convert() {
                            const mode = getMode();
                            const precision = getPrecision();
                            datumInfo.textContent = datum.value;

                            if (mode === 'latlong-to-utm') {
                                const lat = parseFloat(latitude.value);
                                const lng = parseFloat(longitude.value);

                                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                                    const utm = latLongToUTM(lat, lng);
                                    
                                    // Primary output
                                    output.textContent = `${utm.zone}${utm.band} ${utm.easting}E ${utm.northing}N`;
                                    
                                    // Display formats
                                    latlongDisplay.textContent = `${formatNumber(lat, precision)}°, ${formatNumber(lng, precision)}°`;
                                    utmDisplay.textContent = `${utm.zone}${utm.band} ${utm.easting}E ${utm.northing}N`;
                                    
                                    // DMS
                                    const latDMS = convertToDMS(lat);
                                    const lngDMS = convertToDMS(lng);
                                    const latDir = lat >= 0 ? 'N' : 'S';
                                    const lngDir = lng >= 0 ? 'E' : 'W';
                                    dmsDisplay.textContent = `${latDMS.degrees}°${latDMS.minutes}'${formatNumber(latDMS.seconds, 1)}"${latDir}, ${lngDMS.degrees}°${lngDMS.minutes}'${formatNumber(lngDMS.seconds, 1)}"${lngDir}`;
                                    
                                    // MGRS
                                    mgrsDisplay.textContent = generateMGRS(utm.zone, utm.band, utm.easting, utm.northing);
                                    
                                    // Plus Codes
                                    plusCodeDisplay.textContent = generatePlusCode(lat, lng);
                                    
                                    // Coordinate info
                                    zoneInfo.textContent = utm.zone;
                                    bandInfo.textContent = utm.band;
                                    hemisphereInfo.textContent = utm.hemisphere === 'N' ? 'Northern' : 'Southern';
                                    centralMeridian.textContent = formatNumber(utm.centralMeridian, 1) + '°';

                                } else {
                                    clearOutputs();
                                }
                            } else {
                                const zone = parseInt(utmZone.value);
                                const easting = parseFloat(utmEasting.value);
                                const northing = parseFloat(utmNorthing.value);
                                const hemisphere = getHemisphere();

                                if (!isNaN(zone) && !isNaN(easting) && !isNaN(northing)) {
                                    const latlong = utmToLatLong(zone, easting, northing, hemisphere);
                                    const band = getUTMBand(latlong.lat);
                                    
                                    // Primary output
                                    output.textContent = `${formatNumber(latlong.lat, precision)}°, ${formatNumber(latlong.lng, precision)}°`;
                                    
                                    // Display formats
                                    latlongDisplay.textContent = `${formatNumber(latlong.lat, precision)}°, ${formatNumber(latlong.lng, precision)}°`;
                                    utmDisplay.textContent = `${zone}${band} ${easting}E ${northing}N`;
                                    
                                    // DMS
                                    const latDMS = convertToDMS(latlong.lat);
                                    const lngDMS = convertToDMS(latlong.lng);
                                    const latDir = latlong.lat >= 0 ? 'N' : 'S';
                                    const lngDir = latlong.lng >= 0 ? 'E' : 'W';
                                    dmsDisplay.textContent = `${latDMS.degrees}°${latDMS.minutes}'${formatNumber(latDMS.seconds, 1)}"${latDir}, ${lngDMS.degrees}°${lngDMS.minutes}'${formatNumber(lngDMS.seconds, 1)}"${lngDir}`;
                                    
                                    // MGRS
                                    mgrsDisplay.textContent = generateMGRS(zone, band, easting, northing);
                                    
                                    // Plus Codes
                                    plusCodeDisplay.textContent = generatePlusCode(latlong.lat, latlong.lng);
                                    
                                    // Coordinate info
                                    zoneInfo.textContent = zone;
                                    bandInfo.textContent = band;
                                    hemisphereInfo.textContent = hemisphere === 'N' ? 'Northern' : 'Southern';
                                    centralMeridian.textContent = formatNumber(latlong.centralMeridian, 1) + '°';

                                } else {
                                    clearOutputs();
                                }
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            latlongDisplay.textContent = '--';
                            utmDisplay.textContent = '--';
                            dmsDisplay.textContent = '--';
                            mgrsDisplay.textContent = '--';
                            plusCodeDisplay.textContent = '--';
                            zoneInfo.textContent = '--';
                            bandInfo.textContent = '--';
                            hemisphereInfo.textContent = '--';
                            centralMeridian.textContent = '--';
                        }

                        function clearAll() {
                            latitude.value = '';
                            longitude.value = '';
                            utmEasting.value = '';
                            utmNorthing.value = '';
                            clearOutputs();
                            const mode = getMode();
                            if (mode === 'latlong-to-utm') {
                                latitude.focus();
                            } else {
                                utmEasting.focus();
                            }
                        }

                        // Event listeners
                        latitude.addEventListener('input', convert);
                        longitude.addEventListener('input', convert);
                        utmZone.addEventListener('change', convert);
                        utmEasting.addEventListener('input', convert);
                        utmNorthing.addEventListener('input', convert);
                        datum.addEventListener('change', convert);
                        
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        hemisphereRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
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

                        // Sample locations
                        const sampleLocations = document.querySelectorAll('.sample-location');
                        sampleLocations.forEach(button => {
                            button.addEventListener('click', function() {
                                const lat = this.getAttribute('data-lat');
                                const lng = this.getAttribute('data-lng');
                                
                                latitude.value = lat;
                                longitude.value = lng;
                                
                                // Switch to lat/long mode if not already
                                document.querySelector('input[value="latlong-to-utm"]').checked = true;
                                updateInterface();
                                convert();
                                
                                // Update button styles
                                sampleLocations.forEach(btn => btn.classList.remove('bg-red-100', 'text-red-700'));
                                sampleLocations.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-red-100', 'text-red-700');
                            });
                        });

                        // Initialize
                        populateUTMZones();
                        updateInterface();
                        latitude.focus();
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
