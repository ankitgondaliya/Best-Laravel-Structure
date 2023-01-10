@extends('layouts.app')
@section('content')
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                    </div>
                    <form method="post" name="add_edit_form" id="add_edit_form">
                        <div class="row card-body">
                            @csrf
                            <input type="hidden" value={{$data->id}} name="id">
                            <div class="col-md-12  form-group">
                                <label for="editor">{{$title}}</label>
                                <textarea name="data" id="data">
                                    {{$data->data}}
                                </textarea>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@push('js')
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>

    $(document).ready(function () {
        CKEDITOR.replace('data');
        CKEDITOR.instances['editor1'].setData(`{{$data->data}}`)
    });
    $("#add_edit_form").validate({
        ignore: [],
        debug: false,
        rules: {
            data:{
                required: function()
                {
                    CKEDITOR.instances.data.updateElement();
                },
            },
        },
        messages: {
            data:{
                required : "Please enter data",
            },
        },
        submitHandler: function(form,e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('tatic-pages.store') }}",
                type: "POST",
                data: new FormData(form),
                dataType: 'json',
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                beforeSend: function () {
                    $('#loader').show();
                    $('#btn').prop('disabled', true);
                },
                success: function(result)
                {
                    $('#loader').hide();
                    $('#btn').prop('disabled', false);
                    if (result.status) {
                        toastr.success(result.message);
                    } else {
                        toastr.error(result.message);
                    }
                },
                error: function () {
                    toastr.error('Please Reload Page.');
                    $('#loader').hide();
                    $('#btn').prop('disabled', false);
                }
            });
            return false;
        }
    });
</script>

@endpush
