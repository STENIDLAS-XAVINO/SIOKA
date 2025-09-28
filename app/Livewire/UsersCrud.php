<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersCrud extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';
    public $userId;
    public $name, $email, $role, $password, $password_confirmation;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'role' => 'required|in:membre,editeur,admin',
        'password' => 'nullable|string|min:6|confirmed',
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire',
        'email.required' => "L'email est obligatoire",
        'email.email' => "L'email doit être valide",
        'email.unique' => "Cet email est déjà utilisé",
        'role.required' => "Le rôle est obligatoire",
        'password.confirmed' => "La confirmation du mot de passe ne correspond pas",
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetFields()
    {
        $this->reset(['userId', 'name', 'email', 'role', 'password', 'password_confirmation']);
    }

    public function save()
    {
        $rules = $this->rules;

        if ($this->userId) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $this->userId;
        }

        $validated = $this->validate($rules);

        if ($this->userId) {
            $user = User::find($this->userId);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();
        } else {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'password' => Hash::make($validated['password']),
            ]);
        }

        $this->dispatch('closeModal');
        $this->resetFields();
        session()->flash('message', 'Utilisateur enregistré avec succès.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'id' => $id,
            'message' => "Voulez-vous vraiment supprimer cet utilisateur ?"
        ]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'Utilisateur supprimé avec succès.');
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterRole) {
            $query->where('role', $this->filterRole);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.users-crud', [
            'users' => $users
        ]);
    }
}
