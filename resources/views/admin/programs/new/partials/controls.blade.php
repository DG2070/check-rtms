  <div class="rounded-select-container">
      <form method="GET" action="{{ route('programs.new') }}" id="form-select-data">
          @csrf
          <input type="hidden" name="tab_selected" value="#activities_milestones" id="tab_selected">
          <div class="row">
              <div class="col-md-2">
                  <div class="form-group">
                      <label>Fiscal Year</label>
                      <select class="form-control select2 " id="year_select" name="fiscal_year" required>
                          <option value="" disabled>--SELECT FISCAL--</option>
                          <option value="79/80" selected>
                              2079/80</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Program</label>
                      <select class="form-control select2" id="program_select" name="programID" required>
                          <option value="" selected disabled>--SELECT PROGRAM--</option>
                          @foreach ($programs ?? [] as $pro)
                              <option value="{{ $pro->ID }}"
                                  {{ $selectedProgramId == $pro->ID ? 'selected' : '' }}>
                                  {{ $pro->NameLong }} [ {{ $pro->Name }} ]
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Project</label>
                      <select class="form-control select2" id="project_select" name="projectID" required>
                          <option value="" selected>--SELECT PROJECT--</option>
                          @foreach ($projects ?? [] as $project)
                              <option value="{{ $project->ID }}"
                                  {{ $selectedProjectId == $project->ID ? 'selected' : '' }}>
                                  {{ $project->NameLong }} [ {{ $project->TownName }} ]
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-md-2">
                  <div class="form-group">
                      <label class="d-block">&nbsp;</label>
                      <button type="submit" class="btn btn-primary rounded-01">Open</button>
                      {{-- <a href="{{ route('programs.new') }}" class="btn btn-danger rounded-0 ml-2">Clear</a> --}}
                  </div>
              </div>
          </div>
      </form>
  </div>

  <style>
      .dashboard_filter_select2+.select2-container .select2-selection {
          border-radius: 18px !important;
      }
  </style>
