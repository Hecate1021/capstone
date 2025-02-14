<!-- Navbar -->
<header class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
    <div class="container mx-auto px-4 py-2">
        <nav class="flex justify-between items-center">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="text-xl font-bold">
                <img src="{{ asset('images/SebuSavvy.png') }}" alt="Logo" class="h-10">
            </a>

            <!-- Navigation Links and User Icon -->
            <div class="flex items-center space-x-6">
                <ul class="flex items-center space-x-6 list-none">
                    <li>
                        <a href="{{ url('/') }}" class="text-black hover:text-blue-500">Home</a>
                    </li>
                </ul>
                <!-- User Icon with Dropdown -->
                <div class="relative">
                    @if (auth()->user() && auth()->user()->userInfo && auth()->user()->userInfo->profilePath)
                        <img src="{{ asset('storage/images/' . auth()->user()->userInfo->profilePath) }}"
                            alt="Profile Picture" class="rounded-full cursor-pointer" width="40" height="40"
                            id="userDropdownToggle">
                    @else
                        <i class="fa fa-user text-xl cursor-pointer" id="userDropdownToggle"></i>
                    @endif

                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                        <div class="px-4 py-2">
                            <p class="font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="border-t">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-black hover:bg-gray-100">Profile</a>
                            <a href="{{ route('resort.dashboard') }}"
                                class="block px-4 py-2 text-black hover:bg-gray-100">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-black hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<script>
    document.getElementById('userDropdownToggle').onclick = function() {
        var dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    };

    // Optional: Close the dropdown if clicked outside
    window.onclick = function(event) {
        if (!event.target.matches('#userDropdownToggle')) {
            var dropdowns = document.getElementsByClassName("hidden");
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].classList.add('hidden');
            }
        }
    };
</script>
