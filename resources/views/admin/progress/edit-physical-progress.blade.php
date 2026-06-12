@extends('layouts.app')

@section('title', 'Edit Physical Progress')

@include('layouts.includes.data-table.style')

@section('content')

    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('programs.index') }}">Programs</a></li>
                    <li class="breadcrumb-item"><a
                            href="/projects?program={{ $project['programID'] }}">{{ $project['NameLong'] }}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('project.physicalProgress', $project['projectID']) }}">Physical
                            Progress</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Physical Progress of {{ $project->Name }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}


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

    @include('layouts.includes.errors')

    <div class="contents"
        style="width: 100%; height: auto; margin: auto; background: #edeff2; padding-left: 30px; padding-right: 30px; padding-bottom: 30px;">

        <form method="POST"
            action="{{ route('project.physicalProgress.update', ['id' => $project->projectID, 'progress' => $progress->id]) }}"
            enctype="multipart/form-data">

            @csrf

            <div class="row pt-5">
                <div class="col-md-12" id="repeat-visitor">

                    @foreach ($progress->visitor_details['name'] as $key => $name)
                        <div class="row">
                            <div class="form-group col-md-6">
                                @if ($key == 0)
                                    <label for="usr">Name of Visitor/s: *</label>
                                @endif
                                <input type="text" name="visitor_details[name][]" class="form-control"
                                    value="{{ $name ?? '' }}" />
                            </div>
                            <div class="form-group col-md-5">
                                @if ($key == 0)
                                    <label for="pwd">Designation: *</label>
                                @endif
                                <input type="text" name="visitor_details[designation][]" class="form-control"
                                    value="{{ $progress->visitor_details['designation'][$key] ?? '' }}" />
                            </div>
                            @if ($key == 0)
                                <div class="col-md-1"></div>
                            @else
                                <div class="form-group col-md-1 d-flex justify-content-center align-items-center">
                                    <span class="text-danger" onclick="removeElement(this)">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
                <div class="form-group col-md-12 text-right">
                    <button class="btn btn-primary" type="button" onclick="repeatVisitor()">Add</button>
                </div>
            </div>

            <div class="row">
                <div class=" form-group col-md-6">
                    <label for="usr">Date of Visit to Town/Municipality | From : </label>
                    <input placeholder="Select date" type="date" name="from_date" id="example"
                        value="{{ $progress->from_date }}" class="form-control">
                </div>

                <div class="form-group col-md-6">
                    <label for="usr">Date of Visit to Town/Municipality | To : </label>
                    <input placeholder="Select date" name="to_date" type="date" id="example"
                        value="{{ $progress->to_date }}" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="comment">Project Status:</label>
                    {{-- {{ dd($progress->current_status ) }} --}}
                    <textarea class="form-control col-md-12" name="current_status" placeholder="Initial Status" rows="5"
                        id="comment">{{ $progress->current_status }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="usr" class="text-truncate m-0">Person/Authority Met | Position :</label>
                    <input type="text" placeholder="Full Name" class="form-control" name="authority_name"
                        value="{{ $progress->authority_name }}" />
                </div>
                <div class="form-group col-md-4">
                    <label for="pwd">Email address  </label>
                    <input type="text" placeholder="Email" name="authority_email" class="form-control"
                        value="{{ $progress->authority_email }}" />
                </div>
                <div class="form-group col-md-4">
                    <label for="pwd">Contact no  </label>
                    <input type="text" placeholder="Phone No." name="authority_contact" class="form-control"
                        value="{{ $progress->authority_contact }}" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="comment">Activity Performed:</label>
                    <textarea class="form-control col-md-12" name="activity_performed" rows="5" id="comment"
                        placeholder="Initial Status">{{ $progress->activity_performed }}</textarea>
                </div>
            </div>

            <!-- ------field six LAST APPENDABLE FIELDS ROW-------  -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="usr">Progress in percentage</label>
                    <input type="number" placeholder="Progress %" name="physical_progress"
                        value="{{ $progress->physical_progress }}" class="form-control" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4><strong>Documents Upload</strong></h4>
                </div>
                <div class="col-md-12" id="repeat-document">

                    @foreach ($progress->document_uploads['name'] as $key => $upload)
                        <div class="row">
                            <div class="form-group col-md-4">
                                @if ($loop->first)
                                    <label>Name</label>
                                @endif
                                <input type="text" name="document_uploads[name][]" class="form-control"
                                    value="{{ $upload }}">
                            </div>
                            <div class="form-group col-md-3">
                                @if ($loop->first)
                                    <label>Upload Files</label>
                                @endif
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile1" name="files[]"
                                        accept="image/png, image/jpg, image/jpeg">
                                    <label class="custom-file-label" for="inputGroupFile1">
                                        PNG, JPG up to 2MB
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                @if ($loop->first)
                                    <label>Documents</label><br>
                                @endif
                                @if (isset($progress->document_uploads['file']))
                                    <img src="{{ asset('uploads/progress/' . $progress->document_uploads['file'][$key]) }}"
                                        style="max-height: 150px; max-width: 150px;" class="img-thumbnail">
                                @endif
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    @endforeach

                </div>
                <div class="form-group col-md-12 text-right">
                    <button class="btn btn-primary" type="button" onclick="repeatDocument()">Add</button>
                </div>
            </div>

            <div style="width: 100%; display: flex; justify-content: flex-end">
                <button type="submit" class="btn btn-primary">update and submit</button>
            </div>

    </div>

    </form>
    </div>


    <script>
        function repeatVisitor() {
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

        function repeatDocument() {

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
