<?php

namespace App\Livewire\Admin;

use App\Models\Faq;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Kelola FAQ'])]
class FaqManager extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public ?int $editingId = null;

    #[Validate('required|string|max:255')]
    public string $question = '';

    #[Validate('required|string')]
    public string $answer = '';

    public ?int $confirmingDeletionId = null;

    public function resetForm(): void
    {
        $this->reset(['editingId', 'question', 'answer']);
        $this->resetErrorBag();
    }

    public function edit(int $faqId): void
    {
        $faq = Faq::findOrFail($faqId);

        $this->editingId = $faq->id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
    }

    public function save(): void
    {
        $validated = $this->validate();

        Faq::updateOrCreate(
            ['id' => $this->editingId],
            $validated
        );

        $this->resetForm();
        $this->dispatch('toast', message: __('Pertanyaan disimpan.'));
    }

    public function delete(int $faqId): void
    {
        Faq::findOrFail($faqId)->delete();

        $this->confirmingDeletionId = null;
        $this->resetPage();
        $this->dispatch('toast', message: __('Pertanyaan dihapus.'));
    }

    public function render()
    {
        return view('livewire.admin.faq-manager', [
            'faqs' => Faq::query()->latest()->paginate($this->perPage),
        ]);
    }
}
