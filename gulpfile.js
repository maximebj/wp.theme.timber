const gulp = require("gulp")
const stylus = require("gulp-stylus")
const autoprefixer = require("gulp-autoprefixer")
const plumber = require("gulp-plumber")

const bs = require("browser-sync").create() // create a browser sync instance.

gulp.task("browser-sync", function() {
  bs.init({
    proxy: "XXX.dev",
    ghostMode: false,
    open: false,
    notify: false
  })
})

gulp.task("stylus", function() {
  return gulp
    .src("./stylus/main.styl")
    .pipe(plumber())
    .pipe(
      stylus({
        compress: true
      })
    )
    .pipe(autoprefixer({ browsers: ["last 2 versions"] }))
    .pipe(gulp.dest("./css"))
    .pipe(bs.reload({ stream: true }))
})

gulp.task("watch", ["browser-sync"], function() {
  gulp.watch("./stylus/**/*.styl", ["stylus"])
  gulp.watch("./*.php").on("change", bs.reload)
  gulp.watch("./*.js").on("change", bs.reload)
  gulp.watch("./views/**/*.twig").on("change", bs.reload)
})
