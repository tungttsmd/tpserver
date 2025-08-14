<div>
    <select wire:model="exportType">
        <option value="vendors">Vendors</option>
        <option value="products">Products</option>
        <option value="orders">Orders</option>
    </select>

    <button wire:click="export(exportType)">Export</button>
</div>