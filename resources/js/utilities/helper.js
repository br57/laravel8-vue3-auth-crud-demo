import moment from "moment"

export function addNewFilter(existingData, newData) {
    if(typeof newData === 'undefined') return existingData
    if(typeof newData.uuid !== 'undefined') return source

    let newObjects = newData.filter(({ uuid: id1 }) => !existingData.some(({ uuid: id2 }) => id2 === id1))
    return existingData.concat(newObjects)
}

export function addUpdateItem(source, newData) {
    if(typeof newData === 'undefined') return source
    if(typeof newData.uuid === 'undefined') return source

    let data = source.filter(i => i.uuid != newData.uuid)
    data.push(newData)
    return data
}

export function decodeLaravelValidationErrors(Errs){
    let errors = []
    if(typeof Errs !== 'object') return false
    if(Object.keys(Errs).length === 0) return false
    for(let key in Errs){
        if(Errs[key].length > 0){
            for(let ek in Errs[key]){
                errors.push(Errs[key][ek])
            }
        }
    }
    if(errors.length === 0) return false
    return errors
}
export function isEmpty(value) {
    return (
        value === undefined ||
        value === null ||
        value === false ||
        (typeof value === 'object' && Object.keys(value).length === 0) ||
        (typeof value === 'string' && value.trim().length === 0)
    );
}

export function makeFormDataFromObject(input) {
    let data = new FormData();
    Object.keys(input).forEach((k, index) => {
        let type = typeof input[k];
        type = Array.isArray(input[k]) ? 'array' : Object.prototype.toString.call(input[k]) === '[object Object]' ? 'object' : Object.prototype.toString.call(input[k]) === '[object Null]' ? 'null' : type;
        switch (type) {
            case 'object':
                if (input[k]['src'] && typeof input[k]['src'] == 'string' && input[k]['src'].startsWith('blob')) {
                    data.append(k, input[k]);
                } else {
                    data.append(k, JSON.stringify(input[k]));
                }
                break;
            case 'array':
                input[k].forEach(value => {
                    data.append(`${k}[]`, value)
                })
                break;
            case 'null':
                data.append(k, "")
                break
            default:
                let appendVal = (typeof input[k] != 'undefined') ? input[k] : null
                if(appendVal !== null) data.append(k, appendVal);
        }
    });
    return data;
}