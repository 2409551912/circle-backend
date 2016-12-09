var Vue = require("vue");

var Home =  Vue.extend({
    <template>
        <div class="col0 col">

            <div class="module" v-for="(i,l) in list" v-if="i%4 == 0">
                <div>
                    <div class="head">
                        <img src="static/images/download.jpg" alt="">
                        <span>{{l.tag}}</span>
                    </div><div class="focus">
                    <span>关注</span>
                </div>
                </div>

                <ul class="topic">
                    <li v-for="p in l.list">
                        <a href="/index/post/detail/{{p.id}}">{{p.title}}</a>
                    </li>
                </ul>
                <div class="more">
                    <span>
                        <a href="/index/post/list/">更多</a>
                    </span>
                </div>
            </div>


        </div>
        <div class="col1 col">

            <div class="module" v-for="(i,l) in list" v-if="i%4 == 1">
                <div>
                    <div class="head">
                        <img src="static/images/download.jpg" alt="">
                        <span>{{l.tag}}</span>
                    </div><div class="focus">
                    <span>关注</span>
                </div>
                </div>

                <ul class="topic">
                    <li v-for="p in l.list">
                        <a href="/index/post/detail/{{p.id}}">{{p.title}}</a>
                    </li>
                </ul>
                <div class="more">
                    <span>
                        <a href="/index/post/list/">更多</a>
                    </span>
                </div>
            </div>

        </div>

        <div class="col2 col">

            <div class="module" v-for="(i,l) in list" v-if="i%4 == 2">
                <div>
                    <div class="head">
                        <img src="static/images/download.jpg" alt="">
                        <span>{{l.tag}}</span>
                    </div><div class="focus">
                    <span>关注</span>
                </div>
                </div>

                <ul class="topic">
                    <li v-for="p in l.list">
                        <a href="/index/post/detail/{{p.id}}">{{p.title}}</a>
                    </li>
                </ul>
                <div class="more">
                    <span>
                        <a href="/index/post/list/">更多</a>
                    </span>
                </div>
            </div>

        </div>

        <div class="col3 col">

            <div class="module" v-for="(i,l) in list" v-if="i%4 == 3">
                <div>
                    <div class="head">
                        <img src="static/images/download.jpg" alt="">
                        <span>{{l.tag}}</span>
                    </div><div class="focus">
                    <span>关注</span>
                </div>
                </div>

                <ul class="topic">
                    <li v-for="p in l.list">
                        <a href="/index/post/detail/{{p.id}}">{{p.title}}</a>
                    </li>
                </ul>
                <div class="more">
                    <span>
                        <a href="/index/post/list/">更多</a>
                    </span>
                </div>
            </div>

        </div>
    </template>
})
module.exports = Home;