<body class="mt-4">

<?

// print_r($gb->selectPage());
// $gb->addRecord("test",18,"test");


?>


<div class="container" id="gbook">
  <div class="row justify-content-center">
    <div class="col-6">
      <h5 class="text-center">Журнал записей</h5>
      <div vlcass="row justify-content-center">
        <div class="col-12 mb-2 mt-1 fa-xs" v-for=" (val, key, ind) in recordSet">
          <div class="card">
            <div class="card-header bg-warning p-0 pl-2 pt-1">
              <label>#{{(selectedPage-1)*10+key+1}} Имя: {{val.name}}, Возраст: {{val.old}}</label>
            </div>
            <div class="card-body p-2">
              <label>Сообщение:</label>
              <div class="form-control">
                {{val.mes}}
              </div>
            </div>
          </div>
        </div>
        <div class='col-12'>
          <div v-html="formatPager()">

          </div>
        </div>
      </div>
    </div>
    <div class="col-6">
      <h5 class="text-center">Добавить запись</h5>
      <div class="row justify-content-center">
        <div class="col-3 position-fixed fa-xs">
          <div class="form-group">
            <Label>Имя: </Label>
            <input class="form-control" v-model="newRecord.name" />
          </div>
          <div class="form-group">
            <Label>Возраст: </Label>
            <input class="form-control" v-model="newRecord.age" />
          </div>
          <div class="form-group">
            <Label>Запись в журнале: </Label>
            <textarea rows="3" class="form-control" v-model="newRecord.mes"></textarea>
          </div>
          <div class="btn btn-primary btn-sm" @click="makeRecord()">
            Оставить запись
          </div>
          <div class="alert alert-danger mt-2" v-if="displayAlert">
            {{alertText}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>








<script>




</script>
  </body>
