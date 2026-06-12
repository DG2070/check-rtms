@extends('layouts.app')

@section('title', 'Progress Report Input')

@include('layouts.includes.data-table.style')

@section('content')
<div class="row">
  <div class="col-lg-12 margin-tb">
    <div class="pull-left">
      <div class="row mb-3">
        <div class="col-md-12">
          <h4 class="text-center"><strong>Progress Report By P.M.E</strong></h4>
        </div>
      </div>
    </div>
  </div>
</div>

@include("layouts.includes.errors")

<div class="main" style=" height: auto; background: white">
  <div class="contents" style="height: auto; margin: auto; background: #edeff2; padding: 30px;">
    <div>
      <div>
        <div class="row">
          <div class="form-group col-md-3">
            <label for="pwd">Percent on progress</label>
            <input type="password" placeholder="%" class="form-control input-lg" required>
          </div>
        </div>
      </div>
    </div>
    <div>

      <div class="row">
        <div class="form-group col-md-12">
          <label for="remark">Activity Performed:</label>
          <textarea class="form-control col-md-12" name="remark" placeholder="Remark" rows="5" id="remark"
            required></textarea>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <label>Target Achived:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="target" id="achived" value="achived" checked>
            <label class="form-check-label mr-5" for="achived">
              Target Achived
            </label>
            <input class="form-check-input" type="radio" name="target" id="not_achived" value="not_achived">
            <label class="form-check-label" for="not_achived">
              Not Achived
            </label>
          </div>
        </div>
      </div>

      <div class="row" style="display: flex; margin-top: 30px;">
        <div class="form-group col-md-6">
          <label for="main_responsibilityn">Main responsblity</label>
          <input type="text" placeholder="Main responsblity" id="main_responsibilityn" class="form-control input-lg"
            required>
        </div>

        <div class="form-group col-md-6">
          <label for="supportive_responsibility">Supportive responsblity</label>
          <input type="text" placeholder="Supportive responsblity" id="supportive_responsibility"
            class="form-control input-lg" required>
        </div>
      </div>

      <div style="width: 100%; display: flex; justify-content: flex-end">
        <button type="button" class="btn btn-primary">
          Save and submit
        </button>
      </div>

    </div>
  </div>
</div>

@endsection