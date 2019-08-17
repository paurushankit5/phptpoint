<form action="/search" >
  <div class="row mb-3">
    <div class="col-md-9">
      <div class="row">
        <div class="col-md-12 mb-6 mb-md-0">
          <input type="text" name="q" min="4" id="searchbox" required class="mr-3 form-control border-0 px-4"value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}"  placeholder="Search For Tutorials / Sub-Tutorials">
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <input type="submit" class="btn btn-search btn-primary btn-block" value="Search">
    </div>
  </div>
  
</form>
