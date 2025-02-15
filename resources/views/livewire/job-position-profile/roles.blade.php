<div>
    
    @if($roles->count() > 0)
        <div class="form-row">
            <div class="col-12 col-md-3 mt-2">
                <h5>Listado de Funciones</h5> 
            </div>
            <div class="col-12 col-md-9">
                <button class="btn text-white btn-info" wire:click.prevent="add({{$i}})"><i class="fas fa-plus"></i> Agregar</button>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th width="7%">#</th>
                        <th>Descripción</th>
                        <th width="7%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <td>{{ $role->description }}</td>
                        <td class="text-center">
                            <a class="btn btn-outline-danger btn-sm"
                                wire:click="deleteRole({{ $role }})"
                                onclick="return confirm('¿Está seguro que desea eliminar la función?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="form-row">
            <div class="col-12 col-md-2 mt-2">
                <h5>Funciones</h5> 
            </div>
            <div class="col-12 col-md-10">
                <button class="btn text-white btn-info" wire:click.prevent="add({{$i}})"><i class="fas fa-plus"></i> Agregar</button>
            </div>
        </div>
    @endif

    <br>

    @foreach($inputs as $key => $value)
        <div class="form-row">
            <fieldset class="form-group col">
                <label for="for_roles_name">Función</label>
                <input type="text" class="form-control" name="descriptions[]" id="for_description" wire:key="value-{{ $value }}" placeholder="" required>
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="for_button"><br></label>
                <button class="btn btn-danger btn-block" wire:click.prevent="remove({{$key}})">Remover</button>
            </fieldset>
        </div>
    @endforeach
</div>
