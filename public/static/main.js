
var Vue = require("vue");
var VueRouter = require("vue-router");
Vue.use(VueRouter);

//创建组件
var App = Vue.extend({});
//创建路由
var router = new VueRouter();


var vm = new Vue({
    el: '#app',
    data: {
        list:[]
        // currentView: 'Foo'
    }
})


var Post = require("./js/component/post-component.vue");
// vm.currentView = 'Foo';

var Home = require("./js/component/home-component.vue");

Vue.component('Home', Home)
$.ajax({
    type: "GET",
    url: "/index/index_post",
    dataType: "json",
    success: function(data){

        app.currentView = 'Home';
        var list = transformArr(data.list);
        console.log(list);
        vm.$set('list', list);

    }
});


//设置路由
router.map({
    '/foo': {
        component: Foo
    },
    '/bar': {
        component: Bar
    },
    '/': {
        component: Bar
    }
})

router.start(App, '#app');

function transformArr(data){
    var arr = [];
    var index = 0;
    for(var i in data){
        arr[index] = data[i];
        index++;
    }
    return arr;
}