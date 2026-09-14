<?php

namespace App\Http\Livewire\Admin\ContactUs;

use Livewire\Component;
use App\Models\Contactus;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $mySelected = [], $selectAll = false, $deleteId = '';

    public $search_name = "", $search_email = "", $search_phone = "";

    public $items, $item, $message=""; 

    protected $listeners = ['updateSellected', 'updateSession', 'updateDeleteId'];

    public function mount(){
        
        $query = Contactus::query()->orderBy('created_at', 'DESC');
        if($this->search_name  != ''){
            $query = $query->where('name','like','%'.$this->search_name.'%');
            $this->resetPage();
        }

        if($this->search_email  != ''){
            $query = $query->where('email','like','%'.$this->search_email.'%');
            $this->resetPage();
        }
        if($this->search_phone  != ''){
            $query = $query->where('phone','like','%'.$this->search_phone.'%');
            $this->resetPage();
        }

        $this->items = $query->paginate(pagination_count());
     

    }

    public function render()
    {
        $this->mount();
        $links = $this->items;
        $this->items = collect($this->items->items());  
        $items = $this->items;
        // select all empty when change page 
        if(!array_intersect(@$this->items->pluck('id')->toArray(), @$this->mySelected) && @$this->mySelected != []){
            $this->selectAll = false;
            $this->mySelected = [];
        }
      
        return view('livewire.admin.contact-us.table',compact('items','links'));
    }

        // delete selected item -------------------------------------------
        public function delete() {
            Contactus::findOrFail( $this->deleteId)->delete();
            session()->flash('success' , trans('message.admin.deleted_sucessfully') );

        }
     
        // Events All Selected ----------------------------------------------
        public function updatedSelectAll($value){
            if ($value) {
                $this->mySelected = $this->items->pluck('id')->toArray();
            } else {
                $this->mySelected = [];
            }
            $this->emit('updatedSelectAll', $this->mySelected);
        }
    
        public function publishSelected(){
            $items = Contactus::findMany($this->mySelected);
            foreach ($items as $item){
                $item->update(['status' => 1]);
            }
            session()->flash('success' , trans('message.admin.status_changed_sucessfully') );
            $this->clearSelect();
            $this->emit('updatedSelectAll', $this->mySelected);
    
        }
    
        public function unpublishSelected(){
            $items = Contactus::findMany($this->mySelected);
            foreach ($items as $item){
                $item->update(['status' => 0]);
            }
            session()->flash('success' , trans('message.admin.status_changed_sucessfully') );
            $this->clearSelect();
            $this->emit('updatedSelectAll', $this->mySelected);
        }
    
        public function deleteSelected(){
            $items = Contactus::findMany($this->mySelected);
            foreach ($items as $item){
                
                $item->delete();
            }
            session()->flash('success' , trans('message.admin.delete_all_sucessfully') );
            $this->clearSelect();
            $this->emit('updatedSelectAll', $this->mySelected);

        }
    
        public function clearSelect(){
            $this->selectAll = false;
            $this->mySelected = [];
            $this->emit('updatedSelectAll', $this->mySelected);
    
        }
        public function updateSellected($selected){
            if(in_array(@$selected, @$this->mySelected)){
                $this->mySelected = array_diff($this->mySelected, [$selected]);
            }
            else{
                array_push($this->mySelected, $selected);
            }
            if(count($this->mySelected) == pagination_count())$this->selectAll = true;
            else $this->selectAll = false;
            $this->emit('AllupdatedSelect', $this->selectAll);
    
        }
        public function updateDeleteId($id){
            $this->deleteId = $id;
        }
        public function updateSession($msg){
            session()->flash('success' , $msg) ;
        }
}
