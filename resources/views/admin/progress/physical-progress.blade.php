@extends('layouts.app')

@section('title', 'Add Physical Progress')

@include('layouts.includes.data-table.style')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4 class="text-center">
                        <strong>Physical Progress of {{ $project->Name }}</strong>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

@include("layouts.includes.errors")

<div class="contents"
    style="width: 100%; height: auto; margin: auto; background: #edeff2; padding-left: 30px; padding-right: 30px; padding-bottom: 30px;">

    <form method="POST" action="{{ route('project.physicalProgress.store', $project->projectID) }}"
        enctype="multipart/form-data">

        @csrf

        <div class="row pt-5">
            <div class="col-md-12" id="repeat-visitor">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="usr">Name of Visitor/s: *</label>
                        <input type="text" name="visitor_details[name][]" class="form-control" />
                    </div>
                    <div class="form-group col-md-5">
                        <label for="pwd">Designation: *</label>
                        <input type="text" name="visitor_details[designation][]" class="form-control" />
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="form-group col-md-12 text-right">
                <button class="btn btn-primary" type="button" onclick="repeatVisitor()">Add</button>
            </div>
        </div>

        <div class="row">
            <div class=" form-group col-md-6">
                <label for="usr">Date of Visit to Town/Municipality | From  : </label>
                <input placeholder="Select date" type="date" name="from_date" id="example" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label for="usr">Date of Visit to Town/Municipality | To : </label>
                <input placeholder="Select date" name="to_date" type="date" id="example" class="form-control">
            </div>
        </div>

        <div class="row" >
            <div class="form-group col-md-12">
                <label for="comment">Project Status:</label>
                <textarea class="form-control col-md-12" name="status" placeholder="Initial Status" rows="5" id="comment"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="usr" class="text-truncate m-0">Person/Authority Met | Position :</label>
                <input type="text" placeholder="Full Name" class="form-control" name="authority_name" />
            </div>
            <div class="form-group col-md-4">
                <label for="pwd">Email address </label>
                <input type="text" placeholder="Email" name="authority_email" class="form-control" />
            </div>
            <div class="form-group col-md-4">
                <label for="pwd">Contact no  </label>
                <input type="text" placeholder="Phone No." name="authority_contact" class="form-control" />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="comment">Activity Performed:</label>
                <textarea class="form-control col-md-12" name="activity_performed" placeholder="Initial Status" rows="5" id="comment"></textarea>
            </div>
        </div>

        <!-- ------field six LAST APPENDABLE FIELDS ROW-------  -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="usr">Progress in percentage</label>
                <input type="number" placeholder="Progress %" name="physical_progress" class="form-control" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4><strong>Documents Upload</strong></h4>
            </div>
            <div class="col-md-12" id="repeat-document">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" name="document_uploads[name][]" class="form-control">
                    </div>
                    <div class="form-group col-md-5">
                        <label>Upload Files</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile1" name="files[]" accept="image/png, image/jpg, image/jpeg">
                            <label class="custom-file-label" for="inputGroupFile1">
                                PNG, JPG up to 2MB
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="form-group col-md-12 text-right">
                <button class="btn btn-primary" type="button" onclick="repeatDocument()">Add</button>
            </div>
        </div>

            <div style="width: 100%; display: flex; justify-content: flex-end">
                <button type="submit" class="btn btn-primary">Save and submit</button>
            </div>

        </div>

    </form>
</div>


<script>

    function repeatVisitor(){
        const html = `
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" name="visitor_details[name][]" class="form-control" />
                </div>
                <div class="form-group col-md-5">
                    <input type="text" name=visitor_details[designation][] class="form-control" />
                </div>
                <div class="form-group col-md-1 d-flex justify-content-center align-items-center">
                    <span class="text-danger" onclick="removeElement(this)">
                        <i class="fa fa-times"></i>
                    </span>
                </div>
            </div
        `;
        $("#repeat-visitor").append(html);

    }

    function repeatDocument(){

        const child = $("#repeat-document").children().length;

        const html = `
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="document_uploads[name][]">
                </div>
                <div class="form-group col-md-5">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile${ child + 1 }" name="files[]" accept="image/png, image/jpg, image/jpeg">
                        <label class="custom-file-label" for="inputGroupFile${ child + 1 }">
                            PNG, JPG, up to 2MB
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-1 d-flex justify-content-center align-items-center">
                    <span class="text-danger" onclick="removeElement(this)">
                        <i class="fa fa-times"></i>
                    </span>
                </div>
            </div>
        `;

        $("#repeat-document").append(html);
    }

    function removeElement(currentElement) {
        $(currentElement).parent().parent().remove();

    }

    $("#repeat-document").on('change', '.custom-file-input', function(event) {
        $(this).next().text($(this).val().split("\\").pop())
    });



</script>

@endsection
