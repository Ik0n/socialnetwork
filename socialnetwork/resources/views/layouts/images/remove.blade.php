{{
Form::model ( $image, [
'method' => 'DELETE',
'route' => [
'images.destroy' ,
'id' => $image->id,
]
])
}}

<div class="form-group">

    {{
    Form::submit (__('messages.images.remove' ), [
        'class' => 'btn btn-block btn-primary' ,
        ])
    }}

</div>

{{ Form::close () }}