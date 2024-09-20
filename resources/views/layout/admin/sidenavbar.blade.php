<nav class="text-white">
    <x-admin.sidenavbar class="block p-3 hover:bg-pink-700" href="{{ route('orders') }}" name="Orders" wire:navigate />
    <x-admin.sidenavbar class="block p-3 hover:bg-pink-700" href="{{ route('product') }}" name="Products" />
    <x-admin.sidenavbar class="block p-3 hover:bg-pink-700" href="{{ route('users') }}" name="Customers" wire:navigate />
    <x-admin.sidenavbar class="block p-3 hover:bg-pink-700" href="#" name="Settings" />
    <x-admin.sidenavbar class="block p-3 hover:bg-pink-700" href="{{ route('logout') }}" name="Logout" wire:navigate />
</nav>
