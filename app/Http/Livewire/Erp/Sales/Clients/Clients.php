<?php

namespace App\Http\Livewire\Erp\Sales\Clients;

use App\Exports\ClientsExport;
use App\Exports\ProductsExport;
use App\Models\ERP\Inventory\Product;
use App\Models\ERP\Sales\Client;
use App\Models\ERP\Settings\GeneralSetting;
use App\Models\ERP\Settings\Products\Category;
use App\Models\ERP\Settings\Products\Section;
use App\Models\ERP\Settings\Products\SubCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Clients extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $checked = [], $selectPage = false, $selectAll = false;
    public $currency_symbol = null;
    public $search = '', $perPage = 5, $sortField = 'id', $sortAsc = true;
    public $filterByStatus = null;

    protected $listeners = ['recordDeleted' => 'deleteClient', 'CancelDeleted'];

    public function updatedSelectPage($value_in_array)
    {
        //dd($value_in_array); return true
        //if true pluck all id and push it in $this->checked if false empty $this->checked
        if($value_in_array){
            $this->checked = $this->clients->pluck('id')->map(function ($item) {
                return (string)$item;
            })->toArray();
        }else{
            $this->checked = [];
            $this->selectAll = false;
        }
    }
    public function updatedChecked()
    {
        $this->selectPage = false;
        $this->selectAll = false;
    }
    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->clientsQuery->pluck('id')->map(function ($item) {
            return (string)$item;
        })->toArray();
    }
    public function deselectSelected()
    {
        $this->selectPage = false;
        $this->selectAll = false;
        $this->checked = [];
    }

    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => trans('applang.swal_confirm_delete_all_msg'),
            'id'    => $this->checked
        ]);
    }

    public function confirmDelete($product_id, $product_name)
    {
        $this->dispatchBrowserEvent('Swal:DeleteRecordConfirmation', [
            'title' => "<span>".trans('applang.swal_confirm_delete_msg')."<span class='text-danger'>(".$product_name .")</span>"."</span>",
            'id'    => $product_id
        ]);
    }

    public function deleteClient($client_id)
    {
        if($this->checked){ //Bulk Delete
            Client::whereIn('id', $this->checked)->delete();
            $this->checked = [];
            $this->selectPage = false;
            $this->selectAll = false;
            $this->resetPage();
        }else{
            $client = Client::find($client_id); //Single Delete
            $client->delete();
            $this->resetPage();
        }
    }

    public function CancelDeleted()
    {
        $this->checked = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->perPage = 5;
        $this->sortField = 'id';
        $this->sortAsc = true;
        $this->filterByStatus = '';
    }

/*    public function mount()
    {
        $this->brands = [];
        $this->categories = [];
        $this->subcategories = [];
    }

    public function updatedFilterBySection($sectionId)
    {
        $section = Section::find($sectionId);
        $this->brands = $section->brands;
        $this->categories = $section->categories;
    }

    public function updatedFilterByCategory($categoryId)
    {
        $category = Category::find($categoryId);
        $this->subcategories = $category->subcategories;
    }*/


    public function render()
    {
        //get general settings currency
        $gs = GeneralSetting::all()->first();
        if(app()->getLocale() == 'ar'){
            $this->currency_symbol = $gs->basic_currency_symbol;
        }else{
            $this->currency_symbol = $gs->basic_currency;
        }

        return view('livewire.erp.sales.clients.clients',[
            'clients' => $this->clients,
            'currency_symbol' => $this->currency_symbol,
        ]);
    }

    public function getClientsProperty(){
        return $this->clientsQuery->paginate($this->perPage);
    }

    public function getClientsQueryProperty()
    {
        return Client::with('sequential_code')
            ->search(trim($this->search))
            ->when($this->filterByStatus, function ($query){
                $query->where('status', $this->filterByStatus);
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function exportSelected()
    {
//        return (new ClientsExport($this->checked))->download('clients.xlsx');
        return Excel::download(new ClientsExport($this->checked), 'clients.xlsx');
    }
}
