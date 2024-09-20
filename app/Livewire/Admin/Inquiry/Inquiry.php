<?php

namespace App\Livewire\Admin\Inquiry;

use App\Models\Contact;
use App\Models\User;
use Livewire\Component;
// use Livewire\Attributes\On;
// use App\Events\InquiryEvent;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
class Inquiry extends Component
{
    public function render()
    {
        $inquiries=Contact::with('user')->paginate(10);
         //  broadcast(new InquiryEvent($inquiries));
        return view('livewire.admin.inquiry.inquiry',compact('inquiries'));

    }


     //  #[On('echo:contact,InqueryEvent')]
    // public function listenForMessage($event){
    //     dd($event);

    // }

    public function delete($id)
    {
        // dd($id);
        $inquiry = Contact::findOrFail($id);
        $this->authorize('delete', $inquiry);
        $inquiry->delete();
        session()->flash('delete', 'Contact Deleted Successfully.');
    }
}