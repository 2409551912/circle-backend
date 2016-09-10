var config = {

    entry: './public/static/main.js',

    output: {
        path:'./public/static/js',
        filename: 'index.js',
    },

    devServer: {
        inline: true,
        port: 7777
    },

    module: {
        loaders: [ {
            test: /\.js|jsx$/, loaders: ['babel'],
            exclude: /node_modules/,
            loader: 'babel',
            query: {
                presets: ['es2015']
            }
        }]
    }

}

module.exports = config;