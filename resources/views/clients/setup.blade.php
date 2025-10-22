<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - K. Palafox Realty</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<body>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <h1 class="text-3xl font-bold text-white">Setup Your Profile</h1>
                <p class="text-blue-100 mt-2">Provide the information below to complete your profile setup.</p>
            </div>
            <form method="POST" action="{{ route('clients.setup') }}" class="p-8 space-y-6">
                @csrf
                <!-- Relationship Status -->
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heart mr-2 text-blue-600"></i>
                        Relationship Status
                    </label>
                    <select name="relationship_status" id="relationship_status" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select relationship status</option>
                        <option value="single">Single</option>
                        <option value="in_a_relationship">In a Relationship</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                    </select>
                </div>

                <!-- Birthday -->
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                        Birthday
                    </label>
                    <input type="date" name="birthday" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <!-- Age -->
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Age
                    </label>
                    <input type="number" name="age" min="18" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <!-- Gender -->
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-venus-mars mr-2 text-blue-600"></i>
                        Gender
                    </label>
                    <select name="gender" id="gender" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone mr-2 text-blue-600"></i>
                        Contact Number
                    </label>
                    <input type="text" name="contact_number" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <!-- Address -->
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                        Address
                    </label>
                    <input type="text" name="address" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <!-- Source of Income -->
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign mr-2 text-blue-600"></i>
                        Source of Income
                    </label>
                    <select name="source_of_income" id="source_of_income" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select financing type</option>
                        <option value="employed">Employed</option>
                        <option value="self-employed">Self-Employed</option>
                        <option value="freelancer">Freelancer</option>
                        <option value="business-owner">Business Owner</option>
                        <option value="investor">Investor</option>
                        <option value="retired">Retired</option>
                        <option value="student">Student</option>
                        <option value="unemployed">Unemployed</option>
                    </select>
                </div>

                <!-- Current Job -->
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-briefcase mr-2 text-blue-600"></i>
                        Job
                    </label>
                    <input type="text" name="current_job" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-4 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Save
                </button>
            </form>
        </div>
    </div>
</body>
</html>