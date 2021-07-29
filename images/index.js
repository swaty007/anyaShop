const fs = require('fs'),
    request = require('request'),
    {performance} = require('perf_hooks'),
    xlsx = require('node-xlsx'),
    path = require('path');


class ParseImages {
    constructor() {

        this.filesList = [
            {
                filePath: "./MARUMI PICTS",
                xlsxPath: "./MARUMI PICTS/Marumi picts list.xlsx"
            },
        ]

        this.files = []
        this.checkFilesList();

    }

    async checkFilesList () {
        for (let index = 0; index < this.filesList.length; index++) {
            let el = this.filesList[index]
            await this.checkDir(el.filePath)
            console.log(this.files)
            this.checkXlsx(el.xlsxPath)
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
}

new ParseImages()