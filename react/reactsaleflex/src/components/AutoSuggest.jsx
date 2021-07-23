import { useState, useEffect } from 'react'
import axios from 'axios';

const AutoSuggest = () => {

    const [users, setUsers] = useState([]);
    const [suggestions, setSuggestions] = useState([]);
    const [text, setText] = useState('');

    useEffect(() => {
        const loadUsers = async() =>{
          const response = await axios.get('http://localhost:4001/select');
          setUsers(response.data);
          // console.log(response.data);
        }    
        loadUsers();
      }, []);

    const ontypeHandler=(text)=>{
        let matches = [];
        if(text.length>0)
        {
          matches=users.filter(user=>{
            const regex = new RegExp(`${text}`,"gi");
            return user.item_name.match(regex);
          });
        }
    
        // console.log('matches',matches);
        setSuggestions(matches);
        setText(text);
        
      }
    
      const onSuggestHandler = (text) =>{   
        setText(text);
        setSuggestions([])
      }


    return (
        <>
        <div>
         <input type="text" autoComplete="off"  name="fetch" onChange={e=>ontypeHandler(e.target.value)} value={text} onBlur={()=>{ setTimeout(()=>{ setSuggestions([])  },100) }} />   
        </div>

{suggestions && suggestions.map((suggestion, i)=>
    <div className="suggestion" key={i} onClick={()=>onSuggestHandler(suggestion.item_name)} >{suggestion.item_name}</div>
  )}

</>
    )
}

export default AutoSuggest
