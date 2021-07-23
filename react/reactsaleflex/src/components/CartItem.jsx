import Button from "./Button"
const CartItem = ({item_name, quantity, price,  changed, sub, add, myvalue, lineTotal}) => {
    return (
        <>
           <td><label>{item_name}</label></td>
           <td><label>{quantity}</label></td>
           <td><label>{price}</label></td>
           <td><input type="text"  onChange={changed} className="form-control" size={3} />  </td>  
          
         
         <td><Button type="button" value="+" classN="btn btn-primary float-right" style={{ padding: "20px" }} onclick={add} /></td>
         <td><Button type="button" value="-" classN="btn btn-danger float-right" style={{ padding: "20px" }} onclick={sub} /></td> 
         <td>{lineTotal}</td>
        </>
    )
}

export default CartItem
