  <div class=" ">
      <div class=" ">
          <h4><strong>Activity/Milestones: </strong></h4>

          <div class="my-2">
              <button type="button" class="btn btn-primary btn-tdf-primary" data-toggle="modal"
                  data-target="#createNewActivityModal">Add New Activities/Milestones FY
                  20{{ $project->fiscal_year }}</button>
          </div>

          <div class="table-responsive">
              <table class="table table-bordered">
                  <thead class="thead-blue">
                      <tr>
                          <th>S.N</th>
                          <th style="width:50px">Approved Budget FY 20{{ $project->fiscal_year }}
                          </th>
                          <th>Activities/Milestones</th>
                          <th>Performance Indicator</th>
                          <th>Main Responsibilities</th>
                          <th>Supportive Responsibilities</th>
                          <th style="min-width:120px">Added At</th>
                          <th>Operations</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if (!empty($project_datas))
                          @foreach ($project_datas as $item)
                              <tr>
                                  <td>{{ $loop->index + 1 }}.</td>
                                  <td>
                                      <div class="form-control disabled"
                                          style="overflow: visible;height:auto;background-color: #e9ecef;min-height: 34px;">
                                          {{ $item->approved_budget }}
                                      </div>
                                  </td>
                                  <td>
                                      <div class="form-control disabled tdf-max-300"
                                          style="overflow: visible;height:auto;background-color: #e9ecef;min-height: 34px;">

                                          {{ $item->activity_milestone }}
                                      </div>
                                  </td>
                                  <td>
                                      <div class="form-control disabled"
                                          style="overflow: visible;height:auto;background-color: #e9ecef;min-height: 34px;">

                                          {{ $item->performance_indicator }}
                                      </div>
                                  </td>
                                  <td>
                                      @php
                                          $main_responsibility_users = \App\Models\User::whereIn('id', $item->main_responsibility ?? [])->get();
                                      @endphp
                                      <div class="form- control d-flex flex-wrap"
                                          style="border: 1px solid #ccc;font-size: 14px;line-height: 1.42857143;color: #555;border: 1px solid #ccc;border-radius: 4px;min-height: 30px">
                                          @foreach ($main_responsibility_users as $main_responsibility_user)
                                              <div class="badge badge-pill badge-primary py-2 px-2 m-1"
                                                  style="font-size: 13px;font-weight:normal;cursor: pointer;">
                                                  {{ $main_responsibility_user->name }}
                                              </div>
                                          @endforeach
                                      </div>
                                  </td>
                                  <td>
                                      @php
                                          $supportive_responsibility_users = \App\Models\User::whereIn('id', $item->supportive_responsibility ?? [])->get();
                                          
                                      @endphp
                                      <div class="form- control d-flex flex-wrap"
                                          style="border: 1px solid #ccc;font-size: 14px;line-height: 1.42857143;color: #555;border: 1px solid #ccc;border-radius: 4px;min-height: 30px">
                                          @foreach ($supportive_responsibility_users as $supportive_responsibility_user)
                                              <div class="badge badge-pill badge-primary py-2 px-2 m-1"
                                                  style="font-size: 12px;font-weight:normal;cursor: pointer;">
                                                  {{ $supportive_responsibility_user->name }}
                                              </div>
                                          @endforeach
                                      </div>
                                  </td>
                                  <td>
                                      {{ $item->created_at->toDateString() }}
                                  </td>

                                  <td>
                                      <div class="text-center">
                                          <button class="btn btn-dark" type="button" data-toggle="modal"
                                              data-target="#editMilestoneModal-{{ $item->id }}">
                                              <i class="fa fa-pen"></i>
                                          </button>
                                          {!! Form::open([
                                              'method' => 'DELETE',
                                              'route' => ['internal.project.single.milestone.delete', ['internal_project_data_id' => $item->id]],
                                              'style' => 'display:inline',
                                          ]) !!}
                                          <button type="submit" class="btn btn-danger delete-milestone">
                                              <i class="fas fa-trash-alt"></i>
                                          </button>
                                          {!! Form::close() !!}
                                      </div>
                                  </td>
                              </tr>
                          @endforeach
                      @endif


                  </tbody>
              </table>
          </div>
      </div>

      {{-- Timeline Section --}}
      <section class="timeline-section">
          <div>
              <form method="POST" action="{{ route('internal.project.single.milestone.timeline_target.update') }}">
                  @csrf

                  <div class="mt-4">
                      <h4><strong>Timeline:</strong></h4>

                      <div class="table-responsive">
                          <table class="table table-bordered tdf-table-primary">
                              <thead class="thead-blue">
                                  <tr>
                                      <th rowspan="2" class="align-middle text-center">Activities/Milestones</th>
                                      <th colspan="3" class="align-middle text-center">1st Quarter</th>
                                      <th colspan="3" class="align-middle text-center">2nd Quarter</th>
                                      <th colspan="3" class="align-middle text-center">3rd Quarter</th>
                                      <th colspan="3" class="align-middle text-center">4th Quarter</th>
                                      <th rowspan="2" class="align-middle text-center">Total</th>
                                  </tr>
                                  <tr>
                                      <th class="align-middle text-center">1</th>
                                      <th class="align-middle text-center">2</th>
                                      <th class="align-middle text-center">3</th>
                                      <th class="align-middle text-center">1</th>
                                      <th class="align-middle text-center">2</th>
                                      <th class="align-middle text-center">3</th>
                                      <th class="align-middle text-center">1</th>
                                      <th class="align-middle text-center">2</th>
                                      <th class="align-middle text-center">3</th>
                                      <th class="align-middle text-center">1</th>
                                      <th class="align-middle text-center">2</th>
                                      <th class="align-middle text-center">3</th>
                                  </tr>
                              </thead>
                              <tbody>

                                  @if (!empty($project_datas))
                                      @foreach ($project_datas as $item)
                                          @php
                                              $total = 0;
                                          @endphp
                                          <input type="hidden" value="{{ $item->id }}"
                                              name="internal_project_data_id[{{ $item->id }}]">
                                          <tr>
                                              <td class="tdf-max-200">
                                                  {{ $item->activity_milestone }}
                                              </td>
                                              @for ($i = 1; $i < 13; $i++)
                                                  <td style="width: 50px;height:50px"
                                                      class="{{ $item->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $item->is_text == 'yes' ? '' : (isset($item->timeline_target[$i]) && $item->timeline_target[$i] == 1 ? 'background-blue' : '') }}">
                                                      <input type="{{ $item->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                                          name="timeline_target[{{ $item->id }}][{{ $i }}]"
                                                          value="{{ $item->is_text == 'yes' ? $item->timeline_target[$i] ?? '' : 1 }}"
                                                          class="form-control p-0 {{ $item->is_text == 'yes' ? '' : 'd-none' }}"
                                                          {{ $item->is_text == 'yes' ? '' : (isset($item->timeline_target[$i]) && $item->timeline_target[$i] == 1 ? 'checked' : '') }}>
                                                  </td>
                                                  @php
                                                      if ($item->is_text == 'yes' && isset($item->timeline_target[$i])) {
                                                          $total = $total + intval($item->timeline_target[$i]);
                                                      }
                                                  @endphp
                                              @endfor

                                              <td>
                                                  {{ $total > 0 ? $total : '' }}
                                              </td>
                                          </tr>
                                      @endforeach
                                  @endif

                              </tbody>
                          </table>
                      </div>
                  </div>
                  <div class="d-flex justify-content-end" style="gap: 5px;">
                      <button type="submit" class="btn btn-lg btn-primary">Update Timeline</button>
                  </div>

              </form>
          </div>
      </section>

      {{-- !ENDS Timeline Section --}}

  </div>
