const fs = require('fs'),
    request = require('request'),
    {performance} = require('perf_hooks'),
    xlsx = require('node-xlsx'),
    path = require('path'),
    fastFolderSize = require('fast-folder-size'),
    compress_images = require("compress-images"),
    fse = require('fs-extra'),
    {compress} = require('compress-images/promise'),
    needle = require('needle')


class ParseImages {
    constructor() {

        this.filesList = [
            {
                name: "BOYA",
                filePath: "./BOYA PICTS",
                xlsxPath: "./BOYA PICTS/Boya pics 1.xlsx",
            },
            {
                name: "MARUMI PICTS",
                filePath: "./MARUMI PICTS",
                xlsxPath: "./MARUMI PICTS/Marumi picts list.xlsx",
            },
            {
                name: "PHOTEX PICTS",
                filePath: "./PHOTEX PICTS",
                xlsxPath: "./PHOTEX PICTS/Photex pics list.xlsx",
            },
            {
                name: "Rimelite",
                filePath: "./Rimelite",
                xlsxPath: "./Rimelite/Rimelite pics list.xlsx",
            },
            {
                name: "SLIK PICTS",
                filePath: "./SLIK PICTS",
                xlsxPath: "./SLIK PICTS/Slik pict.xlsx",
            },
            {
                name: "TAMRON PICTS",
                filePath: "./TAMRON PICTS",
                xlsxPath: "./TAMRON PICTS/Tamron pics.xlsx",
            },
            {
                name: "TOLIFO PICTS",
                filePath: "./TOLIFO PICTS",
                xlsxPath: "./TOLIFO PICTS/Tolifo pics list.xlsx",
            },
            {
                name: "ZHIYUN PICTS",
                filePath: "./ZHIYUN PICTS",
                xlsxPath: "./ZHIYUN PICTS/ZHIYUN PICTS list.xlsx",
            },
        ]
        this.siteUrl = "http://anya"
        this.siteUrl = "https://anya.infinitum.tech"
        this.saveUrl = `${this.siteUrl}/wp-json/parse/v1/save`

        this.errorSku = new Set()
        this.files = []
        this.xlsx = null
        this.init()


    }

    async init() {
        await this.checkFilesList();
        console.dir(this.errorSku, {'maxArrayLength': null})
    }


    async checkFilesList() {
        for (let index = 0; index < this.filesList.length; index++) {
            let el = this.filesList[index]
            this.files = []
            this.xlsx = null

            // await this.compressImagesSize(el.filePath)
            await this.checkDir(el.filePath)
            // console.log(this.files)
            // console.log('checkXlsx')
            this.checkXlsx(el.xlsxPath)
            // console.log(this.xlsx)
            await this.importToWP(this.filesList[index].name)
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
        let parseData = xlsx.parse(filePath),
            data = parseData[0].data
        data = data.filter(i => i && (Number.isInteger(i[0]) && i[1]))
        this.xlsx = data
    }

    importToWP(listName) {
        return new Promise(async (resolve, reject) => {
            for (let index = 0; index < this.xlsx.length; index++) {
                let el = this.xlsx[index],
                    sku = el[0],
                    img = el[1],
                    imgObj = this.files.find(i => i.name === img)
                if (imgObj) {
                    if (await this.savePost(el, imgObj, listName)) {
                        // return;
                    }
                } else {
                    console.log(`img not finded `, el)
                }
            }
            resolve()
        })
    }

    async savePost(el, imgObj, listName) {
        return new Promise((resolve, reject) => {
            // needle.post(this.saveUrl, {}, {json: true, headers: {'lang': ''}}, (err, res) => {
            let data = {
                img: {file: imgObj.filepath, content_type: 'multipart/form-data'},
                sku: el[0],
                listName: listName,
            }
            // console.log(el)
            // console.log(imgObj)
            // return;
            needle.post(this.saveUrl, data, {multipart: true}, (err, res) => {
                if (err) {
                    console.log(err, 'error Request Save', this.saveUrl, data)
                    setTimeout(() => {
                        resolve(false)
                    }, 10000)
                    return;
                }
                console.log(res.body, 'insertUrl res.body')

                if (res.body) {
                    if (res.body.error) {
                        console.log('error find product sku', res.body.value)
                        this.errorSku.add(res.body.value)
                        resolve(false)
                    }
                }
                setTimeout(() => {
                    resolve(true)
                }, 100)
            })
        })
    }
    compressImagesSize(dirPath) {
        return new Promise((resolve, reject) => {
            fastFolderSize(dirPath, (err, size) => {
                if (err) {
                    throw err;
                }

                console.log(size + ' bytes');
                console.log((size / 1024 / 1024).toFixed(2) + ' Mb');

                compress_images(`${dirPath}/**/*.{jpg,JPG,jpeg,JPEG,png,svg,gif}`, `${dirPath}/min/`, {
                        compress_force: false,
                        statistic: false,
                        autoupdate: true
                    }, false,
                    {jpg: {engine: "mozjpeg", command: ["-quality", "80"]}},
                    // {jpg: {engine: "jpegtran", command: ['-trim', '-progressive', '-copy', 'none', '-optimize']}},
                    {png: {engine: "pngquant", command: ["--quality=60-80", "-o"]}},
                    // {png: {engine: "optipng", command: false}},
                    {svg: {engine: "svgo", command: "--multipass"}},
                    {gif: {engine: "gifsicle", command: ["--colors", "64", "--use-col=web"]}},
                    function (error, completed, statistic) {

                        // console.log(completed);

                        if (error) {
                            console.log(error);
                            console.log(statistic);
                            fse.removeSync(`${statistic.path_out_new}`)
                        }
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