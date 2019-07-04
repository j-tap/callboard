let mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

require("laravel-mix-purgecss");

const CleanWebpackPlugin = require("clean-webpack-plugin");

const GitRevisionPlugin = require("git-revision-webpack-plugin");
const gitRevisionPlugin = new GitRevisionPlugin({
  branch: true,
  lightweightTags: true
});

let date = require("child_process")
  .execSync("git log -1 --format=%cd")
  .toString();
date = new Date(date);
const monthes = [
  "янв",
  "фев",
  "мар",
  "апр",
  "май",
  "июн",
  "июл",
  "авг",
  "сен",
  "окт",
  "ноя",
  "дек"
];
const minutes = (date.getMinutes() < 10) ? '0' : '';
const gitDateStr =
  date.getDate() +
  " " +
  monthes[date.getMonth()] +
  " " +
  date.getHours() +
  ":" + minutes + date.getMinutes();

require("laravel-mix-bundle-analyzer");
require("dotenv").config();

let env_url = process.env.APP_URL.replace("http://", "");

if (mix.isWatching()) {
 mix.bundleAnalyzer();
}

if (mix.inProduction()) {
 mix.version();
}

mix
  .setPublicPath("public")
  .options({
    processCssUrls: false,
    postCss: [],
    uglify: {
      uglifyOptions: {
        compress: true,
        mangle: true,
        output: {
          comments: false,
          beautify: false
        }
      }
    }
  })
  .js("resources/assets/js/client/app.js", "public/js/client.js")
  .js("resources/assets/js/admin/app.js", "public/js/admin.js")
  .sass("resources/assets/sass/client/main.scss", "public/css/client.css")
  .sass("resources/assets/sass/admin.scss", "public/css/admin.css")
  .copy("resources/assets/images", "public/images/", false)
  .copy("resources/assets/landing/img", "public/img/", false)
  .copy("resources/assets/landing/js", "public/js/", false)
  .copy("resources/assets/landing/css", "public/css/", false)
  .copy("resources/assets/landing/files", "public/files/", false)
  .copy("resources/assets/inroot", "public/", false)
  .webpackConfig(webpack => {
    return {
      plugins: [
        new webpack.ProvidePlugin({
          $: "jquery",
          jQuery: "jquery",
          "window.jQuery": "jquery"
        }),
        new webpack.DefinePlugin({
          BUILD_MODE: JSON.stringify(process.env.NODE_ENV),
          APPNAME: JSON.stringify(process.env.APP_NAME),
          GIT_DATE: JSON.stringify(gitDateStr),
          GIT_VERSION: JSON.stringify(gitRevisionPlugin.version()),
          GIT_COMMITHASH: JSON.stringify(gitRevisionPlugin.commithash()),
          GIT_BRANCH: JSON.stringify(gitRevisionPlugin.branch())
        })
        // new CleanWebpackPlugin({
        // 	cleanOnceBeforeBuildPatterns: [path.join(__dirname, 'public/css/*'), path.join(__dirname, 'public/js/*')]
        // }),
      ],
      module: {
        rules: [
          {
            test: /\.pug$/,
            oneOf: [
              {
                resourceQuery: /^\?vue/,
                use: ["pug-plain-loader"]
              },
              {
                use: ["raw-loader", "pug-plain-loader"]
              }
            ]
          }
        ]
      },
      resolve: {
        alias: {
          Vue: path.join(__dirname, "node_modules/vue"),
          vue: path.join(__dirname, "node_modules/vue")
        }
      }
    };
  })
  .extract(["vue", "jquery", "bootstrap"])
  .disableNotifications()
  // .version()
  .sourceMaps()
  .browserSync({
    open: "external",
    host: env_url,
    proxy: env_url
    // 	files: [
    // 		'app/**/*.php',
    // 		'resources/views/**/*.php',
    // 		'public/assets/js/**/*.js',
    // 		'public/assets/css/**/*.css'
    // 	]
  });
// .purgeCss({enabled: true})
