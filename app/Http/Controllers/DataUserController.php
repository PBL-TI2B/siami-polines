<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataUserController extends Controller
{
    /**
     * Get static users from session or default.
     */
    private function getStaticUsers()
    {
        return session('static_users', [
            ['id' => 1, 'name' => 'Contoh Nama Dosen S.Kom., M.Kom', 'nip' => '192992137283786578', 'email' => 'dosen1@polines.ac.id', 'role' => 'Admin', 'photo' => null],
            ['id' => 2, 'name' => 'Dr. John Doe M.T.', 'nip' => '192992137283786579', 'email' => 'dosen2@polines.ac.id', 'role' => 'Auditee', 'photo' => null],
            ['id' => 3, 'name' => 'Jane Smith S.T., M.Eng.', 'nip' => '192992137283786580', 'email' => 'dosen3@polines.ac.id', 'role' => 'Auditor', 'photo' => null],
            ['id' => 4, 'name' => 'Dr. Ahmad Yani S.Kom., Ph.D.', 'nip' => '192992137283786581', 'email' => 'dosen4@polines.ac.id', 'role' => 'Admin', 'photo' => null],
            ['id' => 5, 'name' => 'Budi Santoso S.T., M.Kom.', 'nip' => '192992137283786582', 'email' => 'dosen5@polines.ac.id', 'role' => 'Auditee', 'photo' => null],
            ['id' => 6, 'name' => 'Siti Aminah S.Kom., M.T.', 'nip' => '192992137283786583', 'email' => 'dosen6@polines.ac.id', 'role' => 'Auditor', 'photo' => null],
            ['id' => 7, 'name' => 'Dr. Rina Wijaya M.Eng.', 'nip' => '192992137283786584', 'email' => 'dosen7@polines.ac.id', 'role' => 'Admin', 'photo' => null],
            ['id' => 8, 'name' => 'Eko Prasetyo S.T., M.Kom.', 'nip' => '192992137283786585', 'email' => 'dosen8@polines.ac.id', 'role' => 'Auditee', 'photo' => null],
            ['id' => 9, 'name' => 'Dewi Lestari S.Kom., M.T.', 'nip' => '192992137283786586', 'email' => 'dosen9@polines.ac.id', 'role' => 'Auditor', 'photo' => null],
            ['id' => 10, 'name' => 'Prof. Hadi Susanto Ph.D.', 'nip' => '192992137283786587', 'email' => 'dosen10@polines.ac.id', 'role' => 'Admin', 'photo' => null],
        ]);
    }

    /**
     * Save static users to session.
     */
    private function saveStaticUsers($users)
    {
        session(['static_users' => array_values($users)]); // Reindex array
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('role:admin');
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $users = $this->getStaticUsers();

        // Simulate search
        if ($search = $request->input('search')) {
            $users = array_filter($users, function ($user) use ($search) {
                return stripos($user['name'], $search) !== false ||
                       stripos($user['email'], $search) !== false ||
                       stripos($user['nip'], $search) !== false;
            });
        }

        // Simulate pagination with entries
        $perPage = $request->input('entries', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10; // Validate entries
        $page = $request->input('page', 1);
        $total = count($users);
        $offset = ($page - 1) * $perPage;
        $users = array_slice($users, $offset, $perPage);

        // Create a pseudo-paginator
        $users = new \Illuminate\Pagination\LengthAwarePaginator(
            $users,
            $total,
            $perPage,
            $page,
            ['path' => route('data-user.index')]
        );
        $users->appends(['search' => $search, 'entries' => $perPage]);

        return view('admin.data-user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.data-user.tambah');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nip' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'roles' => 'required|in:Admin,Admin Unit,Auditor,Auditee,Kepala PMPP',
        ]);

        // Simulate uniqueness check for email and nip
        $users = $this->getStaticUsers();
        foreach ($users as $user) {
            if ($user['email'] === $validated['email']) {
                return back()->withErrors(['email' => 'Email already exists.']);
            }
            if ($user['nip'] === $validated['nip']) {
                return back()->withErrors(['nip' => 'NIP already exists.']);
            }
        }

        // Simulate storing
        $newUser = [
            'id' => max(array_column($users, 'id')) + 1,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'role' => $validated['roles'],
            'photo' => null, // Simulate no photo
        ];
        $users[] = $newUser;
        $this->saveStaticUsers($users);

        return redirect()->route('data-user.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $users = $this->getStaticUsers();
        $user = collect($users)->firstWhere('id', $id);

        if (!$user) {
            return redirect()->route('data-user.index')->with('error', 'User not found.');
        }

        return view('admin.data-user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $users = $this->getStaticUsers();
        $user = collect($users)->firstWhere('id', $id);

        if (!$user) {
            return redirect()->route('data-user.index')->with('error', 'User not found.');
        }

        $validated = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nip' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'roles' => 'required|in:Admin,Admin Unit,Auditor,Auditee,Kepala PMPP',
        ]);

        // Simulate uniqueness check for email and nip (excluding current user)
        foreach ($users as $existingUser) {
            if ($existingUser['id'] != $id) {
                if ($existingUser['email'] === $validated['email']) {
                    return back()->withErrors(['email' => 'Email already exists.']);
                }
                if ($existingUser['nip'] === $validated['nip']) {
                    return back()->withErrors(['nip' => 'NIP already exists.']);
                }
            }
        }

        // Simulate update
        foreach ($users as &$u) {
            if ($u['id'] == $id) {
                $u['name'] = $validated['name'];
                $u['email'] = $validated['email'];
                $u['nip'] = $validated['nip'];
                $u['role'] = $validated['roles'];
                $u['photo'] = $u['photo'] ?? null; // Keep existing or null
                break;
            }
        }
        $this->saveStaticUsers($users);

        return redirect()->route('data-user.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $users = $this->getStaticUsers();
        $user = collect($users)->firstWhere('id', $id);

        if (!$user) {
            return redirect()->route('data-user.index')->with('error', 'User not found.');
        }

        // Remove the user
        $users = array_filter($users, function ($u) use ($id) {
            return $u['id'] != $id;
        });
        $this->saveStaticUsers($users);

        return redirect()->route('data-user.index')->with('success', 'User berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('selected_users', []);
        User::whereIn('id', $ids)->each(function ($user) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->delete();
        });
        return redirect()->route('data-user.index')->with('success', 'Users berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $selectedUsers = $request->input('selected_users', []);
        if (!empty($selectedUsers)) {
            User::whereIn('id', $selectedUsers)->delete();
            return redirect()->route('data-user.index')->with('success', 'User terpilih berhasil dihapus.');
        }
        return redirect()->route('data-user.index')->with('error', 'Tidak ada user yang dipilih.');
    }
}
