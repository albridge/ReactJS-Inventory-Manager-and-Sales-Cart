// import './App.css';
// import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter as Router, Route } from 'react-router-dom';
import Header from './components/Header';
import Navigation from './components/Navigation';
import Field from './components/Field';
import Button from './components/Button';
import Search from './components/Search';
import About from './components/About';

import AutoSuggest from './components/AutoSuggest';
import { useState, useEffect, useRef } from 'react'
import axios from 'axios';

import CartItem from './components/CartItem';
import Monday from './components/Monday';
import Container from './components/Container';
import './layout2.css';




const App = () => {


  const [item_name, setName] = useState('');
  const [quantity, setQuantity] = useState('');
  const [price, setPrice] = useState('');
  const [supply_price, setSupply_price] = useState('');
  const [re_order, setReorder] = useState('');
  const [users, setUsers] = useState([]);
  const [suggestions, setSuggestions] = useState([]);
  const [text, setText] = useState('');
  const [invo, setInvo] = useState('');
  const [items, setItems] = useState([]);
  const [inventory, setInventory] = useState([]);
  const [editLine, setEditLine] = useState();

  const [edited, setEdited] = useState();



  

  let rendered = useRef(false);


  useEffect(() => {       
    loadUsers();
    loadInventory();
  }, []);

  
  useEffect(()=>
    {
      // console.log(edited)
      if(rendered.current===true){
        
        updateInventory(edited);
        
      }else{
        rendered.current=true;
      }  
      
  },[edited,rendered]
  );

  
  
  

  // updateInventory(edited)
  
  const [editPrice, setEditPrice] = useState('')
  const [editQuantity, setEditQuantity] = useState('')
  const [editReOrder, setEditReorder] = useState('')
  const [editItemName, setEditItemName] = useState('');

  const [editId, setEditId] = useState('');



  const loadInventory = async() =>{
    const response = await axios.get('http://localhost:4001/inventory');
    setInventory(response.data);
    // console.log(response.data);
  } 
  
  const loadUsers = async() =>{
    const response = await axios.get('http://localhost:4001/select');
    setUsers(response.data);
    // console.log(response.data);
  } 

  


  // useEffect(() => {
    
   
  // }, []);
  

  const pullInventory=(invo)=>{
    let matches = [];
    if(invo.length>0)
    {
      matches=inventory.filter(inv=>{
        const regex = new RegExp(`${invo}`,"gi");
        return inv.item_name.match(regex);
      });

      // console.log('matches',matches);
    
    }
    setInventory(matches);
    setInvo(invo);    
    
  }


  const handleChange = (e) => {
    // console.log(e.target.value);
    if (e.target.name === 'item_name') {
      let name = e.target.value
      setName(name);
    } else if (e.target.name === 'price') {
      let price = e.target.value;
      setPrice(price);
    } else if (e.target.name === 'quantity') {
      let quantity = e.target.value;
      setQuantity(quantity);
    } else if (e.target.name === 'supply_price') {
      let supply = e.target.value;
      setSupply_price(supply);
    } else if (e.target.name === 're_order') {
      let order = e.target.value;
      setReorder(order);
    }
  }

  const handleSubmit = async (history) => {
    let details = { item_name, price, quantity, re_order, supply_price }
    // console.log(details);
    // do sub    
    const res = await fetch('http://localhost:4001/add', {
      method: 'POST',
      headers: {
        'Content-type': 'application/json',
      },
      body: JSON.stringify(details),
    });

    const data = await res.json();

    setName('');
    setPrice('');
    setQuantity('');
    setSupply_price('');
    setReorder('');

    // end sub



    // console.log(data);
  }
  

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

  const onSuggestHandler = (text,id) =>{   
    // setText(text); // uncomment this lne to set selected value to text field
    setText('');
    setSuggestions([]);
    getItem(id);
  }

  const clearCart = () =>{
    setItems([]);
  }




  // get selected item to build shoping cart

  const getItem = async (item_id) => {
    
    // console.log(item_id);
    // get item details    
    const res = await fetch('http://localhost:4001/getItem?item_id='+encodeURIComponent(item_id), {
      method: 'GET',
      headers: {
        'Content-type': 'application/json',
      },
      // body: JSON.stringify(item_id),
    });
    const data = await res.json();    
    addOn(data[0]);
    // setItems([...items, data]);   
    // console.log(items);

  }  


  // checkout

  const checkOut = async () => {   
    
    // get item details    
    const res = await fetch('http://localhost:4001/checkout', {
      method: 'POST',
      headers: {
        'Content-type': 'application/json',
      },
      body: JSON.stringify(items),
    });
    // const data = await res.json();    
       
    // console.log(data);
    setItems(['']);

  }




  const addOn = (data) =>{    
    // console.log(data);
    const exist = items.find((x) => x.id === data.id);
    if(exist){
      setItems(items.map((x)=>x.id === data.id ? {...exist, qty: exist.qty+=1} : x))
    }else{
      setItems([...items, {...data, qty:1}]);
    }
  }


  // function getItem(item_id){
  //   return fetch('http://localhost:4001/getItem?item_id='+encodeURIComponent(item_id),
  //   {
  //   	method: "GET",
  //     headers: {
  //       'Accept': 'application/json',
  //       'Content-Type': 'application/json',
  //     },
  //   })
  //   .then((response) => response.json())
  //   .then((responseData) => {
  //     console.log(responseData);
  //     return responseData;
  //   })
  //   .catch(error => console.warn(error));
  // }

  const Add = (e,i) =>{  
    let comp = items[i];
    addOn(comp);      
  }

  const Subtract = (e,i) =>{
    let data = items[i];    
    const exist = items.find((x) => x.id === data.id);
    if(exist){
      if(exist.qty>0){
      setItems(items.map((x)=>x.id === data.id ? {...exist, qty: exist.qty-=1} : x))
      }
    }
    
  }

  const Raise = (e,i) =>{
    // console.log(e); 
    let n = e.target.value;
    let data = items[i];    
    const exist = items.find((x) => x.id === data.id);
    if(exist){
      setItems(items.map((x)=>x.id === data.id ? {...exist, qty: Number(n)} : x))
    }
  }


  // edit fetch single line record

  const getEdit = async (item_id) => {
    
    

    // console.log(item_id);
    // get item details    
    const res = await fetch('http://localhost:4001/getEdit?item_id='+encodeURIComponent(item_id), {
      method: 'GET',
      headers: {
        'Content-type': 'application/json',
      },
      // body: JSON.stringify(item_id),
    });
    const data = await res.json();    
    
    setEditLine(data[0]);   
    // console.log(data[0]);
   

  }

  const edit = (i) =>{   
    // alert(i) ;
    // let item = inventory[i]
    // console.log(item); 

    setEditId(i);    
    
    getEdit(i);    

    setEditPrice('')
    setEditQuantity('')
    setEditReorder('') 
    setEditItemName('')
  }


  const doEdit = (e) =>{
    if(e.target.name==='editReOrder'){
    setEditReorder(e.target.value);
  }else if(e.target.name==='price'){
    setEditPrice(e.target.value)
  }else if(e.target.name==='quantity'){
    setEditQuantity(e.target.value);
  }else if(e.target.name==='item_name'){
    setEditItemName(e.target.value);
  }
  
}
  
const doUpdate = (e) =>{
  
  e.preventDefault();
  
  let oldItemName = editLine.item_name;
  let oldReOrder = editLine.re_order;
  let oldQuantity = editLine.quantity;
  let oldPrice = editLine.price;
  let old = {oldItemName, oldReOrder, oldQuantity, oldPrice}
  
  setEdited({editReOrder,editItemName,editPrice,editQuantity,editId,old})
  
  // updateInventory(edited);

  // setTimeout(()=>{ updateInventory(edited)  },5000) 
  loadInventory();
}


const updateInventory = async (object) => {
  // console.log('posted data',tas);
  const res = await fetch('http://localhost:4001/updateInv', {
    method: 'PUT',
    headers: {
      'Content-type': 'application/json',
    },
    body: JSON.stringify(object),
  })

 
  const data = await res.json(); 
  // setEditLine(data);
  console.log("result",data);
  // setInventory(inventory);
  

}



  return (
    <div className="body">
      <Router>
  

<Route path="/" exact render={()=>
(
  <>


<div className="block line">
  <div className="row">
<Header />
        <Navigation />
        </div>
        </div>
      

      <div className="form1 row">
        
      <div className="block col-2">     
      <Search  type="text" autoComplete="off" name="" fetchit={e=>pullInventory(e.target.value)} value={invo} onBlur={()=>{ setTimeout(()=>{ loadInventory()  },100) }} />
        <table className="table table-bordered table-striped">
        <tbody>
          <tr>
            <th></th>
            <th>ITEM NAME</th>
            <th>PRICE</th>
            <th>QUANTITY</th>
            <th>RE-ORDER</th>
            </tr>
        {inventory && inventory.map((inv, i)=>
        
          <tr key={inv.id} onClick={(e)=>edit(inv.id)} style={{cursor:'pointer'}}>
            <td>{i+1}</td>
            <td>{inv.item_name}</td>
            <td>{inv.price}</td>
            <td>{inv.quantity}</td>
            <td>{inv.re_order}</td>
          </tr>
          
          ) }
          </tbody>
</table> 

      </div>
      <div className="col-1 block">
        
      <div>
        <form onSubmit={doUpdate}>
        <table className="table table-bordered table-striped">
          <tbody>
        {editLine && 
       <>
        <tr>    
            <th>Edit {editLine.item_name.toUpperCase()} details</th>
            </tr>
            <tr>     
            <th>Item ID {editLine.id}</th>            
            </tr>           
            <tr>
            <td><input name="item_name" type="text" placeholder={editLine.item_name} value={editItemName} onChange={(e)=>setEditItemName(e.target.value)} /></td>
            </tr>
            <tr>
            <td><input name="price" type="text" placeholder={editLine.price} value={editPrice} onChange={(e)=>setEditPrice(e.target.value)} /></td>
            </tr>
            <tr>
            <td><input name="quantity" type="text" placeholder={editLine.quantity} value={editQuantity} onChange={(e)=>setEditQuantity(e.target.value)} /></td>
            </tr>
            <tr>
            <td><input type="text" name="editReOrder" placeholder={editLine.re_order} value={editReOrder} onChange={(e)=>setEditReorder(e.target.value)} /></td>         
      </tr>
      <tr>
        <td>
        <input type="submit" value="Update" className="btn btn-primary" />
        </td>
      </tr>
      </>
}
        </tbody>
        </table>
        </form>
      </div>
      </div>


   

      </div>

  </>
)}
/>

<Route path='/search' render={()=>(
  <>
  <div className="block">
  <Navigation />
  </div>

  <div className="row">
  <div className="colo-1 block"> 
    <div>  
      <Search type="text" autoComplete="off" name="item_name" fetchit={e=>ontypeHandler(e.target.value)} value={text} onBlur={()=>{ setTimeout(()=>{ setSuggestions([])  },100) }} />
        </div>
        {suggestions && suggestions.map((suggestion, i)=>
          <div className="suggestion" key={i} onClick={()=>onSuggestHandler(suggestion.item_name,suggestion.id)} >{suggestion.item_name}</div>
        )}

</div>
<div className="col-2 block">
        <table className="table table-bordered table-striped">
<tbody>
  <tr>
    <th>ITEM NAME</th>
    <th>QTY</th>
    <th>PRICE</th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
          {items && items.map((item, i)=>
          <tr key={i}>           
          <CartItem item_name={item.item_name} quantity={item.qty} price={item.price}  changed={(e)=>Raise(e,i)} add={(e) => Add(e,i)} sub={(e) => Subtract(e,i)} />
          </tr>
          )}
          <tr>
            <td>TOTAL</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td><Button type="button" value="Clear Cart" classN="btn btn-danger float-right" style={{ padding: "20px" }} onclick={(e) => clearCart()} /></td>
            <td><Button type="button" value="Checkout" classN="btn btn-primary float-right" style={{ padding: "20px" }} onclick={(e) => checkOut()} /></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          </tbody>
        </table>
      </div>

      <div className="col-1 block"></div>
      
      </div>

      <div className="block"> &copy; 2021 </div>
  </>
  
)}

/>


<Route path='/create' render={()=>(
         <>
         <div className="block col-1">
         <Navigation />
         </div>

         <div className="row" >
           <div className="col-1 block"></div>
         <dov className="block col-2" style={{textAlign:"center"}}>
        <Field name="item_name" value={item_name} placeholder="Enter Name" type="text" changed={(e) => handleChange(e)} cname="form-control" size=""  />
        <Field name="quantity" value={quantity} placeholder="Enter quantity" type="text" changed={(e) => handleChange(e)} cname="form-control" size=""/>
        <Field name="price" value={price} placeholder="Enter Price" type="text" changed={(e) => handleChange(e)} cname="form-control" size=""/>
        <Field name="supply_price" value={supply_price} placeholder="Enter Supply Price" type="text" changed={(e) => handleChange(e)} cname="form-control" size=""/>
        <Field name="re_order" value={re_order} placeholder="Enter Re-order quantity" type="text" changed={(e) => handleChange(e)} cname="form-control" size=""/>

        <Button type="button" value="Save" classN="btn btn-danger float-right" style={{ padding: "20px" }} onclick={(e) => handleSubmit()} />
        
        
      
        </dov>

        <div className="col-1 block"></div>
        </div>
         </>
       )}
       />

      
<Route path='/about' component={About} />
<Route path='/monday' component={Monday} />
<Route path='/Container' component={Container} />

    
      </Router>
    </div>
  );
}

export default App;





