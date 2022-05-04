<?php

namespace App\Http\Livewire\Warehouse\Origins;

use App\Models\Warehouse\Origin;
use Livewire\Component;
use Livewire\WithPagination;

class OriginIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $store;
    public $search;

    public function render()
    {
        return view('livewire.warehouse.origins.origin-index', [
            'origins' => $this->getOrigins()
        ]);
    }

    public function getOrigins()
    {
        $search = "%$this->search%";

        $origins = Origin::query()
            ->when($this->search, function($query) use($search) {
                $query->where('name', 'like', $search);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $origins;
    }

    public function deleteOrigin(Origin $origin)
    {
        $origin->delete();
        $this->render();
    }
}
