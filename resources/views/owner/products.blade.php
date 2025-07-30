@extends('owner.olayouts.main')
@section('content')
<!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk-->
<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</header>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div id="loader"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{--<li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="">Home</a></li>--}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Add Batch Modal -->
                <div class="modal fade" id="addBatchModal" tabindex="-1" aria-labelledby="addBatchModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="addBatchForm" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addBatchModalLabel">Add New Batch</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="batchName" class="form-label">Batch Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required />
                                </div>
                                <div class="mb-3">
                                    <label for="createdDate" class="form-label">Created Date</label>
                                    <input type="number" class="form-control" id="price" name="price" required />
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="perishable" name="perishable_status" required>
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div id="addBatchError" class="text-danger d-none"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Add Batch</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="container my-4">
                    <h2 class="mb-4">Products</h2>
                    <div class="mb-3">
                        <button id="addBtn" class="btn btn-success">Add</button>
                        <button id="editBtn" class="btn btn-primary" disabled>Edit</button>
                        <button id="deleteBtn" class="btn btn-danger" disabled>Delete</button>
                    </div>
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col"><input type="checkbox" id="selectAll" /></th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Perishable</th>
                            </tr>
                        </thead>
                        <tbody id="batchTableBody">
                            @foreach($populate as $product)
                            <tr>
                                <td><input type="checkbox" class="rowCheckbox" /></td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->perishable_status ? 'Yes' : 'No'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <script>
                    const selectAllCheckbox = document.getElementById('selectAll');
                    const addBtn = document.getElementById('addBtn');
                    const editBtn = document.getElementById('editBtn');
                    const deleteBtn = document.getElementById('deleteBtn');
                    const batchTableBody = document.getElementById('batchTableBody');

                    function updateButtons() {
                        const checkedBoxes = document.querySelectorAll('.rowCheckbox:checked');
                        editBtn.disabled = checkedBoxes.length !== 1;
                        deleteBtn.disabled = checkedBoxes.length === 0;
                    }

                    function setupRowListeners() {
                        const rows = document.querySelectorAll('#batchTableBody tr');
                        rows.forEach(row => {
                            row.addEventListener('click', (event) => {
                                if (event.target.type !== 'checkbox') {
                                    const checkbox = row.querySelector('.rowCheckbox');
                                    checkbox.checked = !checkbox.checked;
                                    updateButtons();
                                    updateSelectAllState();
                                }
                            });
                        });
                    }

                    function updateSelectAllState() {
                        const checkboxes = document.querySelectorAll('.rowCheckbox');
                        const allChecked = checkboxes.length > 0 && 
                            [...checkboxes].every(cb => cb.checked);
                        selectAllCheckbox.checked = allChecked;
                    }

                    // Initial setup
                    setupRowListeners();

                    selectAllCheckbox.addEventListener('change', () => {
                        document.querySelectorAll('.rowCheckbox').forEach(checkbox => {
                            checkbox.checked = selectAllCheckbox.checked;
                        });
                        updateButtons();
                        updateSelectAllState();
                    });

                    batchTableBody.addEventListener('change', (event) => {
                        if (event.target.classList.contains('rowCheckbox')) {
                            updateButtons();
                            updateSelectAllState();
                        }
                    });

                    addBtn.addEventListener('click', () => {
                        addBatchForm.reset();
                        addBatchError.classList.add('d-none');
                        addBatchError.textContent = '';
                        addBatchModal.show();
                    });

                    editBtn.addEventListener('click', () => {
                        const checkedBoxes = document.querySelectorAll('.rowCheckbox:checked');
                        if (checkedBoxes.length === 1) {
                            const row = checkedBoxes[0].closest('tr');
                            alert('Edit function triggered for Product: ' + row.cells[1].textContent);
                        }
                    });

                    deleteBtn.addEventListener('click', () => {
                        const checkedBoxes = document.querySelectorAll('.rowCheckbox:checked');
                        if (checkedBoxes.length > 0 && confirm(`Are you sure you want to delete ${checkedBoxes.length} product(s)?`)) {
                            checkedBoxes.forEach(cb => cb.closest('tr').remove());
                            updateButtons();
                            updateSelectAllState();
                        }
                    });

                    // Modal handling
                    const addBatchModal = new bootstrap.Modal(document.getElementById('addBatchModal'));
                    const addBatchForm = document.getElementById('addBatchForm');
                    const addBatchError = document.getElementById('addBatchError');

                    addBatchForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        addBatchError.classList.add('d-none');
                        
                        const formData = new FormData(this);
                        fetch("{{route('owner.products.add') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            const newRow = document.createElement('tr');
                            newRow.innerHTML = `
                                <td><input type="checkbox" class="rowCheckbox" /></td>
                                <td>${data.name}</td>
                                <td>${data.price}</td>
                                <td>${data.perishable_status ? 'Yes' : 'No'}</td>
                            `;
                            batchTableBody.appendChild(newRow);
                            
                            setupRowListeners();
                            updateButtons();
                            updateSelectAllState();
                            addBatchModal.hide();
                        })
                        .catch(error => {
                            addBatchError.textContent = error.message || 'An error occurred. Please try again.';
                            addBatchError.classList.remove('d-none');
                        });
                    });
                </script>
            </div>
        </div>
    </section>
</div>
@endsection