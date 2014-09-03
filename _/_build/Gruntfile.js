module.exports = function(grunt) {
    grunt.initConfig({
        // running `grunt less` will compile once
        less: {
            development: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2
                },
                files: {
                    "../../styles.css": "../../styles.less"
                }
            }
        },

        smushit: {
            development: {
                src: ['../images/original/**/*.png','../images/original/**/*.jpg'],
                dest: '../images/min'
            }
            
        },

        // running `grunt watch` will watch for changes
        watch: {
            less: {
                files: ['../../*.less', '../bootstrap/less/*.less'],
                tasks: ["less"]
            },
            smushit: {
                files: ['../images/original/**/*.png','../images/original/**/*.jpg'],
                tasks: ["smushit"]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-smushit');

};