let gbook = new Vue({
  el: '#gbook',
  data: {
    recordSet:{},
    totalRecords:0,
    selectedPage:1,
    displayAlert:false,
    alertText:"",
    newRecord:{
      name:"",
      age:"",
      mes:"",
    }
  },
  methods:{
    formatPager:function(){
      let step=10;
      let totalPages=parseInt((this.totalRecords)/step);
      let htmlToRet=[];

      if(this.totalRecords-totalPages>0){
        totalPages++;
      }

      for (let i = 0; i < totalPages; i++) {
        htmlToRet.push('<div class="btn btn-primary mr-2 ml-2 fa-xs " onclick="setPage('+(i+1)+')">');
        htmlToRet.push(i+1);
        htmlToRet.push('</div>');
      }

      return htmlToRet.join('');
    },
    getRecords:function(){
      let data={
        "action":"getRecords",
        "start":this.selectedPage,
      };

      console.log(data);

      axios({
        method:"POST",
        url:DIRNAME+"/include/api/localApi.php",
        data:data,
      }).then(function(r){
        console.log(r.data);
          if(r.data.code==200){
            gbook.recordSet=r.data.rt.records;
            gbook.totalRecords=r.data.rt.overall;

          }
      }).catch(err=>{
        console.log(err);
      });
    },
    makeRecord:function(){
      this.displayAlert=false;
      this.alertText="";

      if(isNaN(this.newRecord.age)){
        this.displayAlert=true;
        this.alertText="Укажите правильный возраст";

        return;
      }
      if(this.newRecord.name=='' || this.newRecord.age=='' || this.newRecord.mes==''){
        this.displayAlert=true;
        this.alertText="Все поля формы обязательны к заполнению";

        return;
      }


      let data={
        "action":"putRecord",
        "name":this.newRecord.name,
        "age":this.newRecord.age,
        "mes":this.newRecord.mes
      };

      console.log(data);
      axios({
        method:"POST",
        url:DIRNAME+"/include/api/localApi.php",
        data:data,
      }).then(function(r){
        console.log(r.data);
        console.log(Object.keys(r.data.rt));
          if(r.data.code==200){
            if(!Object.keys(r.data.rt).length){
              gbook.displayAlert=true;
              gbook.alertText="Что-то пошло не так, попробуйте снова";
            }else{
              gbook.recordSet=r.data.rt.records;
              gbook.totalRecords=r.data.rt.overall;
              gbook.newRecord.name="";
              gbook.newRecord.age="";
              gbook.newRecord.mes="";
            }


          }
      }).catch(err=>{
        console.log(err);
      });
    },
  },
  watch:{
    'newRecord.name':function(){

      let nameArr=(""+this.newRecord.name).split(" ");
      let upperedName;
      $(nameArr).each(function(ind, val){
        if(!(""+val).length) return;
        nameArr[ind]=val[0].toUpperCase()+val.substring(1);
      });

      this.newRecord.name=nameArr.join(" ");

    },
    'selectedPage':function(){
      this.getRecords();
    },
    'newRecord.age':function(){
      this.newRecord.age=parseInt((""+this.newRecord.age).substring(0,2));
      if(isNaN(this.newRecord.age)){
        this.newRecord.age="";
      }
    }
  }
});


function setPage(page){
  console.log(page);
  gbook.selectedPage=page;
}
