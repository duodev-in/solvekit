<x-tool-page-layout
    title="Grams to Calories Calculator - SolveKit"
    description="Professional grams to calories calculator for food weight to energy conversion. Calculate nutritional values, macronutrients, and energy content for diet planning and nutrition tracking."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Grams To Calories Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Food Item Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Food Category
                                                                                </label>
                                                                                <select 
                                                                                    id="foodCategory" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="grains" selected>Grains & Cereals</option>
                                                                                    <option value="proteins">Proteins & Meat</option>
                                                                                    <option value="dairy">Dairy & Eggs</option>
                                                                                    <option value="fruits">Fruits</option>
                                                                                    <option value="vegetables">Vegetables</option>
                                                                                    <option value="fats">Fats & Oils</option>
                                                                                    <option value="snacks">Snacks & Sweets</option>
                                                                                    <option value="beverages">Beverages</option>
                                                                                    <option value="custom">Custom Food Item</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Specific Food Item -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Food Item
                                                                                </label>
                                                                                <select 
                                                                                    id="foodItem" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <!-- Options populated dynamically -->
                                                                                </select>
                                                                            </div>

                                                                            <!-- Custom Food (when custom is selected) -->
                                                                            <div class="space-y-2" id="customFoodContainer" style="display: none;">
                                                                                <label for="customCalories" class="block text-sm font-semibold text-gray-700">
                                                                                    Calories per 100g
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="customCalories" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter calories per 100g"
                                                                                        step="1"
                                                                                        min="0"
                                                                                        max="1000"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">cal/100g</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Energy content per 100 grams</p>
                                                                            </div>

                                                                            <!-- Weight Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="weightValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Food Weight
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="weightValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter weight (e.g., 100)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="weightUnit">grams</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter the weight of food to analyze</p>
                                                                            </div>

                                                                            <!-- Weight Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Weight Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="weightUnitSelect" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="g" selected>Grams (g)</option>
                                                                                    <option value="kg">Kilograms (kg)</option>
                                                                                    <option value="oz">Ounces (oz)</option>
                                                                                    <option value="lb">Pounds (lb)</option>
                                                                                    <option value="cup">Cups (volume)</option>
                                                                                    <option value="tbsp">Tablespoons</option>
                                                                                    <option value="tsp">Teaspoons</option>
                                                                                </select>
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Nutritional Analysis Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-l-4 border-green-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Total Calories</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Energy content calculation</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-green-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-green-600 hover:text-green-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Nutritional Breakdown Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Energy Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Energy Content</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Calories</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="caloriesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Food calories (kcal)</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Kilojoules</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="kilojoulesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Energy in kJ</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cal/100g</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="caloriesPer100gDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Energy density</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Macronutrients -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Macronutrients</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Carbohydrates</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="carbsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Grams (4 cal/g)</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Protein</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="proteinDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Grams (4 cal/g)</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Fat</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="fatDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Grams (9 cal/g)</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Daily Values -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Daily Values</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">% Daily Calories</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="dailyCaloriesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Based on 2000 cal diet</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg border-l-4 border-amber-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Serving Size</h5>
                                                                                            <div class="text-lg font-bold text-amber-600 font-mono" id="servingSizeDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Portion information</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Weight</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="totalWeightDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Total food weight</div>
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
                <!-- Quick Food Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Food Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-weight="100" data-food="rice">100g Rice</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-weight="150" data-food="chicken_breast">150g Chicken</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-weight="200" data-food="apple">200g Apple</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors" data-weight="250" data-food="milk">250ml Milk</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Nutrition Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Calorie</strong> = 4.184 kJ</div>
                                                        <div><strong>Carbs</strong> = 4 calories/gram</div>
                                                        <div><strong>Protein</strong> = 4 calories/gram</div>
                                                        <div><strong>Fat</strong> = 9 calories/gram</div>
                                                        <div><strong>Alcohol</strong> = 7 calories/gram</div>
                                                        <div><strong>Daily intake</strong> = ~2000 calories</div>
                                                        <div><strong>1 cup</strong> = ~240ml volume</div>
                                                        <div><strong>1 tbsp</strong> = ~15ml volume</div>
                                                        <div><strong>1 oz</strong> = 28.35 grams</div>
                                                        <div><strong>1 lb</strong> = 453.6 grams</div>
                                                        <div><strong>Fiber</strong> = 0 calories/gram</div>
                                                        <div><strong>Water</strong> = 0 calories/gram</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const foodCategory = document.getElementById('foodCategory');
                        const foodItem = document.getElementById('foodItem');
                        const customCalories = document.getElementById('customCalories');
                        const weightValue = document.getElementById('weightValue');
                        const weightUnitSelect = document.getElementById('weightUnitSelect');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Container elements
                        const customFoodContainer = document.getElementById('customFoodContainer');
                        const weightUnit = document.getElementById('weightUnit');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const caloriesDisplay = document.getElementById('caloriesDisplay');
                        const kilojoulesDisplay = document.getElementById('kilojoulesDisplay');
                        const caloriesPer100gDisplay = document.getElementById('caloriesPer100gDisplay');
                        const carbsDisplay = document.getElementById('carbsDisplay');
                        const proteinDisplay = document.getElementById('proteinDisplay');
                        const fatDisplay = document.getElementById('fatDisplay');
                        const dailyCaloriesDisplay = document.getElementById('dailyCaloriesDisplay');
                        const servingSizeDisplay = document.getElementById('servingSizeDisplay');
                        const totalWeightDisplay = document.getElementById('totalWeightDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Food database with nutritional information
                        const foodDatabase = {
                            grains: {
                                name: 'Grains & Cereals',
                                items: {
                                    rice: { name: 'White Rice (cooked)', calories: 130, carbs: 28, protein: 2.7, fat: 0.3, density: 1.5 },
                                    brown_rice: { name: 'Brown Rice (cooked)', calories: 112, carbs: 23, protein: 2.6, fat: 0.9, density: 1.6 },
                                    bread: { name: 'White Bread', calories: 265, carbs: 49, protein: 9, fat: 3.2, density: 0.3 },
                                    whole_wheat_bread: { name: 'Whole Wheat Bread', calories: 247, carbs: 41, protein: 13, fat: 4.2, density: 0.35 },
                                    pasta: { name: 'Pasta (cooked)', calories: 131, carbs: 25, protein: 5, fat: 1.1, density: 1.2 },
                                    oats: { name: 'Oatmeal (cooked)', calories: 68, carbs: 12, protein: 2.4, fat: 1.4, density: 1.8 },
                                    quinoa: { name: 'Quinoa (cooked)', calories: 120, carbs: 22, protein: 4.4, fat: 1.9, density: 1.6 }
                                }
                            },
                            proteins: {
                                name: 'Proteins & Meat',
                                items: {
                                    chicken_breast: { name: 'Chicken Breast (skinless)', calories: 165, carbs: 0, protein: 31, fat: 3.6, density: 1.0 },
                                    beef: { name: 'Lean Beef', calories: 250, carbs: 0, protein: 26, fat: 15, density: 1.0 },
                                    salmon: { name: 'Salmon', calories: 208, carbs: 0, protein: 20, fat: 13, density: 1.0 },
                                    tuna: { name: 'Tuna (canned in water)', calories: 116, carbs: 0, protein: 26, fat: 0.8, density: 1.0 },
                                    eggs: { name: 'Eggs (whole)', calories: 155, carbs: 1.1, protein: 13, fat: 11, density: 1.0 },
                                    tofu: { name: 'Tofu', calories: 76, carbs: 1.9, protein: 8, fat: 4.8, density: 1.0 },
                                    beans: { name: 'Black Beans (cooked)', calories: 132, carbs: 24, protein: 8.9, fat: 0.5, density: 1.6 }
                                }
                            },
                            dairy: {
                                name: 'Dairy & Eggs',
                                items: {
                                    milk: { name: 'Whole Milk', calories: 61, carbs: 4.8, protein: 3.2, fat: 3.3, density: 1.03 },
                                    skim_milk: { name: 'Skim Milk', calories: 34, carbs: 5, protein: 3.4, fat: 0.2, density: 1.03 },
                                    cheese: { name: 'Cheddar Cheese', calories: 403, carbs: 1.3, protein: 25, fat: 33, density: 1.1 },
                                    yogurt: { name: 'Plain Yogurt', calories: 59, carbs: 3.6, protein: 10, fat: 0.4, density: 1.05 },
                                    greek_yogurt: { name: 'Greek Yogurt', calories: 59, carbs: 3.6, protein: 10, fat: 0.4, density: 1.1 },
                                    butter: { name: 'Butter', calories: 717, carbs: 0.1, protein: 0.9, fat: 81, density: 0.9 }
                                }
                            },
                            fruits: {
                                name: 'Fruits',
                                items: {
                                    apple: { name: 'Apple', calories: 52, carbs: 14, protein: 0.3, fat: 0.2, density: 0.8 },
                                    banana: { name: 'Banana', calories: 89, carbs: 23, protein: 1.1, fat: 0.3, density: 0.9 },
                                    orange: { name: 'Orange', calories: 47, carbs: 12, protein: 0.9, fat: 0.1, density: 0.85 },
                                    grapes: { name: 'Grapes', calories: 62, carbs: 16, protein: 0.6, fat: 0.2, density: 0.8 },
                                    strawberries: { name: 'Strawberries', calories: 32, carbs: 7.7, protein: 0.7, fat: 0.3, density: 0.9 },
                                    avocado: { name: 'Avocado', calories: 160, carbs: 9, protein: 2, fat: 15, density: 0.97 }
                                }
                            },
                            vegetables: {
                                name: 'Vegetables',
                                items: {
                                    broccoli: { name: 'Broccoli', calories: 34, carbs: 7, protein: 2.8, fat: 0.4, density: 0.9 },
                                    carrots: { name: 'Carrots', calories: 41, carbs: 10, protein: 0.9, fat: 0.2, density: 0.9 },
                                    spinach: { name: 'Spinach', calories: 23, carbs: 3.6, protein: 2.9, fat: 0.4, density: 0.9 },
                                    tomatoes: { name: 'Tomatoes', calories: 18, carbs: 3.9, protein: 0.9, fat: 0.2, density: 0.95 },
                                    potatoes: { name: 'Potatoes (baked)', calories: 93, carbs: 21, protein: 2.5, fat: 0.1, density: 1.1 },
                                    sweet_potato: { name: 'Sweet Potato', calories: 86, carbs: 20, protein: 1.6, fat: 0.1, density: 1.1 }
                                }
                            },
                            fats: {
                                name: 'Fats & Oils',
                                items: {
                                    olive_oil: { name: 'Olive Oil', calories: 884, carbs: 0, protein: 0, fat: 100, density: 0.92 },
                                    coconut_oil: { name: 'Coconut Oil', calories: 862, carbs: 0, protein: 0, fat: 100, density: 0.92 },
                                    almonds: { name: 'Almonds', calories: 579, carbs: 22, protein: 21, fat: 50, density: 0.6 },
                                    peanuts: { name: 'Peanuts', calories: 567, carbs: 16, protein: 26, fat: 49, density: 0.64 },
                                    walnuts: { name: 'Walnuts', calories: 654, carbs: 14, protein: 15, fat: 65, density: 0.52 }
                                }
                            },
                            snacks: {
                                name: 'Snacks & Sweets',
                                items: {
                                    chocolate: { name: 'Dark Chocolate (70%)', calories: 546, carbs: 46, protein: 8, fat: 31, density: 1.2 },
                                    cookies: { name: 'Chocolate Chip Cookies', calories: 488, carbs: 68, protein: 5.4, fat: 21, density: 0.8 },
                                    chips: { name: 'Potato Chips', calories: 536, carbs: 50, protein: 7, fat: 35, density: 0.4 },
                                    ice_cream: { name: 'Vanilla Ice Cream', calories: 207, carbs: 24, protein: 3.5, fat: 11, density: 0.5 }
                                }
                            },
                            beverages: {
                                name: 'Beverages',
                                items: {
                                    soda: { name: 'Cola Soda', calories: 42, carbs: 11, protein: 0, fat: 0, density: 1.0 },
                                    juice: { name: 'Orange Juice', calories: 45, carbs: 10, protein: 0.7, fat: 0.2, density: 1.05 },
                                    coffee: { name: 'Black Coffee', calories: 2, carbs: 0, protein: 0.3, fat: 0, density: 1.0 },
                                    tea: { name: 'Green Tea', calories: 1, carbs: 0, protein: 0, fat: 0, density: 1.0 },
                                    beer: { name: 'Beer', calories: 43, carbs: 3.6, protein: 0.5, fat: 0, density: 1.0 },
                                    wine: { name: 'Red Wine', calories: 85, carbs: 2.6, protein: 0.1, fat: 0, density: 0.99 }
                                }
                            }
                        };

                        // Weight conversion factors to grams
                        const weightConversions = {
                            g: 1,
                            kg: 1000,
                            oz: 28.3495,
                            lb: 453.592,
                            cup: 240, // approximate for liquids
                            tbsp: 15,
                            tsp: 5
                        };

                        function formatNumber(num, decimals = 1) {
                            return num.toLocaleString(undefined, { 
                                maximumFractionDigits: decimals, 
                                minimumFractionDigits: 0 
                            });
                        }

                        function formatCalories(value) {
                            if (value === 0) {
                                return '0';
                            }

                            if (value < 1) {
                                return value.toLocaleString(undefined, { maximumSignificantDigits: 2 });
                            }

                            return value.toLocaleString(undefined, { maximumFractionDigits: value < 10 ? 1 : 0 });
                        }

                        function describeWeight(weight, unit, weightInGrams) {
                            if (unit === 'g') {
                                return `${formatNumber(weight, 1)} g`;
                            }

                            return `${formatNumber(weight, 2)} ${weightUnit.textContent} (${formatNumber(weightInGrams, 0)} g)`;
                        }

                        function updateFoodItems() {
                            const category = foodCategory.value;
                            const isCustom = category === 'custom';
                            
                            customFoodContainer.style.display = isCustom ? 'block' : 'none';
                            foodItem.closest('.space-y-2').style.display = isCustom ? 'none' : 'block';
                            
                            if (!isCustom) {
                                const categoryData = foodDatabase[category];
                                foodItem.innerHTML = '';
                                
                                Object.keys(categoryData.items).forEach(itemKey => {
                                    const item = categoryData.items[itemKey];
                                    const option = document.createElement('option');
                                    option.value = itemKey;
                                    option.textContent = item.name;
                                    foodItem.appendChild(option);
                                });
                            }
                        }

                        function updateWeightUnit() {
                            const unit = weightUnitSelect.value;
                            const unitNames = {
                                g: 'grams',
                                kg: 'kg',
                                oz: 'oz',
                                lb: 'lb',
                                cup: 'cups',
                                tbsp: 'tbsp',
                                tsp: 'tsp'
                            };
                            weightUnit.textContent = unitNames[unit] || 'grams';
                        }

                        function calculate() {
                            const category = foodCategory.value;
                            const item = foodItem.value;
                            const weight = parseFloat(weightValue.value);
                            const unit = weightUnitSelect.value;
                            
                            if (!isNaN(weight) && weight > 0) {
                                let foodData;
                                let weightInGrams = weight * weightConversions[unit];
                                
                                if (category === 'custom') {
                                    const customCal = parseFloat(customCalories.value);
                                    if (isNaN(customCal) || customCal <= 0) {
                                        clearOutputs();
                                        return;
                                    }
                                    
                                    foodData = {
                                        name: 'Custom Food',
                                        calories: customCal,
                                        carbs: 0, // Unknown for custom
                                        protein: 0,
                                        fat: 0,
                                        density: 1.0
                                    };
                                } else {
                                    foodData = foodDatabase[category].items[item];
                                    if (!foodData) {
                                        clearOutputs();
                                        return;
                                    }
                                }
                                
                                // Adjust weight for volume measurements using density
                                if (['cup', 'tbsp', 'tsp'].includes(unit)) {
                                    weightInGrams = weight * weightConversions[unit] * foodData.density;
                                }
                                
                                // Calculate nutritional values
                                const calories = (foodData.calories * weightInGrams) / 100;
                                const carbs = (foodData.carbs * weightInGrams) / 100;
                                const protein = (foodData.protein * weightInGrams) / 100;
                                const fat = (foodData.fat * weightInGrams) / 100;
                                const kilojoules = calories * 4.184;
                                
                                
                                // Update primary output
                                output.textContent = formatCalories(calories) + ' kcal';
                                resultTitle.textContent = 'Total Calories';
                                resultDescription.textContent = `${describeWeight(weight, unit, weightInGrams)} of ${foodData.name} = ${formatCalories(calories)} ${calories === 1 ? 'calorie' : 'calories'}`;

                                // Display energy content
                                caloriesDisplay.textContent = formatCalories(calories) + ' kcal';
                                kilojoulesDisplay.textContent = formatCalories(kilojoules) + ' kJ';
                                caloriesPer100gDisplay.textContent = formatNumber(foodData.calories, 0) + ' cal';

                                // Display macronutrients
                                carbsDisplay.textContent = formatNumber(carbs, 1) + 'g';
                                proteinDisplay.textContent = formatNumber(protein, 1) + 'g';
                                fatDisplay.textContent = formatNumber(fat, 1) + 'g';

                                // Daily values (based on 2000 calorie diet)
                                const dailyCaloriePercent = (calories / 2000) * 100;
                                dailyCaloriesDisplay.textContent = formatNumber(dailyCaloriePercent, 1) + '%';
                                servingSizeDisplay.textContent = formatNumber(weight, 1) + ' ' + weightUnit.textContent;
                                totalWeightDisplay.textContent = formatNumber(weightInGrams, 0) + 'g';


                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Total Calories';
                            resultDescription.textContent = 'Enter a food weight to calculate calories';
                            caloriesDisplay.textContent = '--';
                            kilojoulesDisplay.textContent = '--';
                            caloriesPer100gDisplay.textContent = '--';
                            carbsDisplay.textContent = '--';
                            proteinDisplay.textContent = '--';
                            fatDisplay.textContent = '--';
                            dailyCaloriesDisplay.textContent = '--';
                            servingSizeDisplay.textContent = '--';
                            totalWeightDisplay.textContent = '--';
                        }

                        function clearAll() {
                            weightValue.value = '';
                            foodCategory.value = 'grains';
                            weightUnitSelect.value = 'g';
                            customCalories.value = '';
                            updateFoodItems();
                            updateWeightUnit();
                            clearOutputs();
                            weightValue.focus();
                        }

                        // Event listeners
                        foodCategory.addEventListener('change', function() {
                            updateFoodItems();
                            calculate();
                        });
                        
                        foodItem.addEventListener('change', calculate);
                        customCalories.addEventListener('input', calculate);
                        weightValue.addEventListener('input', calculate);
                        weightUnitSelect.addEventListener('change', function() {
                            updateWeightUnit();
                            calculate();
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

                        // Example buttons
                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                const weight = this.getAttribute('data-weight');
                                const food = this.getAttribute('data-food');
                                
                                weightValue.value = weight;
                                
                                // Find the food in the database
                                for (const [categoryKey, categoryData] of Object.entries(foodDatabase)) {
                                    if (categoryData.items[food]) {
                                        foodCategory.value = categoryKey;
                                        updateFoodItems();
                                        foodItem.value = food;
                                        break;
                                    }
                                }
                                
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-green-100', 'text-green-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-green-100', 'text-green-700');
                            });
                        });

                        // Initialize
                        updateFoodItems();
                        updateWeightUnit();
                        weightValue.focus();

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
