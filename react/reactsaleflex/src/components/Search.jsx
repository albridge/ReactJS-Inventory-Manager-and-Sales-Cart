const Search = ({fetchit, text, value, onBlur, clearField}) => {

    return (
        <div>
         <input className="form-control" placeholder="Enter search item name" type={text} autoComplete="off"  name="fetch" onChange={fetchit} value={value} onBlur={onBlur} onClick={clearField} />   
        </div>
    )
}

export default Search
