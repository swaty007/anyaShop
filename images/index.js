const fs = require('fs'),
    request = require('request'),
    {performance} = require('perf_hooks'),
    xlsx = require('node-xlsx'),
    path = require('path'),
    fastFolderSize = require('fast-folder-size'),
    compress_images = require("compress-images"),
    fse = require('fs-extra'),
    {compress} = require('compress-images/promise')


class ParseImages {
    constructor() {

        this.filesList = [
            {
                filePath: "./MARUMI PICTS",
                xlsxPath: "./MARUMI PICTS/Marumi picts list.xlsx"
            },
        ]

        this.files = []
        this.init()


    }

    async init() {
        this.checkFilesList();

    }


    async checkFilesList() {
        for (let index = 0; index < this.filesList.length; index++) {
            let el = this.filesList[index]

            await this.fileSizeUpdate(el.filePath)
            // await this.checkDir(el.filePath)
            // console.log(this.files)
            // this.checkXlsx(el.xlsxPath)
        }
    }

    checkDir(dirPath) {
        return new Promise((resolve, reject) => {
            fs.readdir(dirPath, {withFileTypes: true}, async (errDir, files) => {
                // console.log(files)
                for (let index = 0; index < files.length; index++) {
                    let el = files[index];
                    await new Promise(async (resolve, reject) => {
                        if (el.isDirectory()) {
                            await this.checkDir(path.join(dirPath, el.name));
                            resolve();
                        }

                        if (el.isFile()) {
                            this.files.push({
                                name: el.name,
                                dir: dirPath,
                                filepath: path.join(dirPath, el.name),
                            })
                            resolve()
                        }
                    })
                }
                resolve()
            })
        })
    }

    checkXlsx(filePath) {
        console.log('checkXlsx')
        let parseData = xlsx.parse(filePath),
            data = parseData[0].data
        data = data.filter(i => i && (Number.isInteger(i[0]) && i[1]))
        console.log(data)
    }

    fileSizeUpdate(dirPath) {
        return new Promise((resolve, reject) => {
            fastFolderSize(dirPath, (err, size) => {
                if (err) {
                    throw err;
                }

                console.log(size + ' bytes');
                console.log((size / 1024 / 1024).toFixed(2) + ' Mb');

                compress_images(`${dirPath}/**/*.{jpg,JPG,jpeg,JPEG,png,svg,gif}`, `${dirPath}/min/`, {
                        compress_force: false,
                        statistic: true,
                        autoupdate: true
                    }, false,
                    {jpg: {engine: "mozjpeg", command: ["-quality", "80"]}},
                    {png: {engine: "pngquant", command: ["--quality=40-70", "-o"]}},
                    {svg: {engine: "svgo", command: "--multipass"}},
                    {gif: {engine: "gifsicle", command: ["--colors", "64", "--use-col=web"]}},
                    function (error, completed, statistic) {
                        // console.log(error);
                        console.log(completed);
                        if (completed) {
                            fse.copySync(`${dirPath}/min`, `${dirPath}`, {overwrite: true}, function (err) {
                                if (err) {
                                    console.error(err);
                                } else {
                                    console.log("success!");
                                }
                            });
                            fse.removeSync(`${dirPath}/min`)
                            resolve()
                        }
                        // console.log(statistic);
                    }
                );
            });
        })
    }
}

new ParseImages()