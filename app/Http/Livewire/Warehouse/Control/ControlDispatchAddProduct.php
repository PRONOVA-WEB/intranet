<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Cfg\Program;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\ControlItem;
use App\Models\Warehouse\Product;
use Livewire\Component;

class ControlDispatchAddProduct extends Component
{
    public $store;
    public $control;
    public $control_item_id;
    public $barcode;
    public $quantity = 0;
    public $max = 0;

    public function rules()
    {
        return [
            'control_item_id'   => 'required|exists:wre_control_items,id',
            'quantity'          => 'required|integer|min:1|max:' . $this->max,
        ];
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-dispatch-add-product', [
            'controlItems' => $this->getControlItems()
        ]);
    }

    public function getPrograms()
    {
        $idsPrograms = Control::query()
            ->where('wre_controls.store_id', $this->control->store_id)
            ->select([
                'wre_control_items.program_id',
            ])
            ->join('wre_control_items', 'wre_controls.id', '=', 'wre_control_items.control_id')
            ->groupBy('wre_control_items.program_id')
            ->pluck('wre_control_items.program_id');

        $programs = Program::findMany($idsPrograms);

        return $programs;
    }

    public function getControlItems()
    {
        $productsOutStock = Product::outStock($this->store, $this->control->program);

        $controlItems = ControlItem::query()
            ->whereHas('control', function($query) {
                $query->whereStoreId($this->store->id);
            })
            ->whereProgramId($this->control->program_id)
            ->groupby('program_id', 'product_id')
            ->whereNotIn('product_id', $productsOutStock)
            ->get();

        return $controlItems;
    }

    public function updatedControlItemId()
    {
        $controlItem = ControlItem::find($this->control_item_id);
        $this->barcode = ($controlItem) ? $controlItem->product->barcode : '';
        $this->max = 0;
        $this->quantity = 0;
        if($this->control_item_id)
            $this->max = Product::lastBalance($controlItem->product, $controlItem->program);
    }

    public function addProduct()
    {
        $dataValidated = $this->validate();

        $controlItem = ControlItem::find($this->control_item_id);
        $lastBalance = Product::lastBalance($controlItem->product, $controlItem->program);
        $dataValidated['balance'] = $lastBalance - $dataValidated['quantity'];
        $dataValidated['control_id'] = $this->control->id;
        $dataValidated['program_id'] = $this->control->program_id;
        $dataValidated['product_id'] = $controlItem->product_id;

        $controlItem = ControlItem::query()
            ->whereControlId($this->control->id)
            ->whereProgramId($controlItem->program_id)
            ->whereProductId($controlItem->product_id);

        if($controlItem->exists())
        {
            $controlItem = clone $controlItem->first();
            $controlItem->update([
                'quantity'  => $controlItem->quantity + $dataValidated['quantity'],
                'balance'   => $lastBalance - $dataValidated['quantity'],
            ]);
        }
        else
        {
            $controlItem = ControlItem::create($dataValidated);
        }

        $this->resetInput();
        $this->emit('refreshControlProductList');
    }

    public function resetInput()
    {
        $this->control_item_id = null;
        $this->max = 0;
        $this->quantity = 0;
        $this->barcode = '';
    }
}
