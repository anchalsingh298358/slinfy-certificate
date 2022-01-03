<?php
  $replacement = " ";
	$getCharacter = substr($entity, -1);

  if($getCharacter != 's')
  {
    $string = ucfirst($entity);
  }
  else
  {
    $string = ucfirst(substr($entity, 0, -1).$replacement);
  }

  
?>

@can('edit_'.$entity)	
    <a href="{{ route($entity.'.edit', [str_singular($entity) => $id])  }}" class="btn btn-xs btn-info">
      <i class="fa fa-edit"></i> Edit
    </a>
@endcan


@can('delete_'.$entity)

<li class="list-inline-item">
    <a class="delete-data info-btn" href="javascript:void(0);"
       data-url="{{route($entity.'.destroy', ['id' => $id])}}"
       data-title="Are you sure?"
       data-body= "{{$string.' will be deleted!'}}"
       data-icon="" data-success="{{$string.' successfully deleted!'}}"
       data-cancel="{{$string.' is safe!'}}"
       title="Delete"><i class="fa fa-trash"> Delete</i>
    </a>
</li>
   <!--  {!! Form::open( ['method' => 'delete', 'url' => route($entity.'.destroy', ['user' => $id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to delete it?")']) !!}
        <button type="submit" class="btn-delete btn btn-xs btn-danger">
            <i class="glyphicon glyphicon-trash"></i>
        </button>
    {!! Form::close() !!} -->
@endcan


