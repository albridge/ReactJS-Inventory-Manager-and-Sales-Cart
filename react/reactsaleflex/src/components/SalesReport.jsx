import DatePicker from './DatePicker';
import { useState, useEffect, useRef } from 'react'
import Navigation from './Navigation';
import '../layout2.css';
  
const SalesReport = () => {
const [selected, setSelected] = useState(new Date());
const [selected3, setSelected3] = useState(new Date());
  // const [endDate, setEndDate] = useState(new Date());
const [sales, setSales] = useState([]);

let rendered = useRef(false);
  

  const getReport = (e) =>{
    console.log(e)   
    setSelected(e)
    
  }


  const getReport3 = (e) =>{
    console.log(e)   
    setSelected3(e)
    
  }

  useEffect(()=>
  {
    // console.log(edited)
    if(rendered.current===true){      
      setSales(sales)         
    }else{
      // rendered.current=true;
    }      
},[sales]
);

  const getReport2 = async () =>{
   
    let newDate = selected.toLocaleDateString()
    let newDate3 = selected3.toLocaleDateString()
    // let set = newDate.replace('/','-');
    let set = newDate.split('/')
    let got = set[2]+'-'+set[0].padStart(2,0)+'-'+set[1]

    let set3 = newDate3.split('/')
    let got3 = set3[2]+'-'+set3[0].padStart(2,0)+'-'+set3[1]
    // alert(got);
    // let gotAll = {one:got,two:got3};
    // console.log(gotAll.one); return;

    const res = await fetch('http://localhost:4001/getItems?item_id='+encodeURIComponent(got)+'&endate='+encodeURIComponent(got3), {
      method: 'GET',
      headers: {
        'Content-type': 'application/json',
      },
      // body: JSON.stringify(item_id),
    });
    const data = await res.json();   
    // console.log(data) ;
    setSales(data)

   

   

    

    
  }

  const  titleCase = (string) => {
    var splitStr = string.toLowerCase().split(' ')
    let newString = []
    for(var i=0; i<splitStr.length; i++)
    {
     newString[i] = splitStr[i].charAt(0).toUpperCase()+splitStr[i].substring(1)
    }
    return newString.join(' ');
}

    // fetch report by date
    // const salesReport = async () => {  
    //     let dates = {startDate, endDate} 
        
    //     // get item details    
    //     const res = await fetch('http://localhost:4001/salesreport', {
    //       method: 'POST',
    //       headers: {
    //         'Content-type': 'application/json',
    //       },
    //       body: JSON.stringify(items),
    //     });
    //     const data = await res.json();    
           
    //     // console.log(data);
        
    
    //   }




let totsale = 0;
let totpaid = 0
    return (
        <>
        <div className="container">
        <div className="col-md block">
        <Navigation />
        </div>
        
               <div>
        <div >Sales Report: Select report date range</div>
        <>
    <DatePicker startDate={selected} theDate={(e) => getReport(e)}  format="YYYY-MM-dd"   />
    <DatePicker startDate={selected3} theDate={(e) => getReport3(e)}  format="YYYY-MM-dd"   />
    <input type="button" onClick={getReport2} value="Get Report" className="btn btn-primary" />
    </>
      </div>

      <div>
        <table className="table table-striped table-bordered">
          <tbody>
            <tr>
              <th></th>             
              <th>TRANSACTION ID</th>
              <th>AMOUNT PAID</th>
              <th>SALE VALUE</th>
              <th>DETAILS</th>
            </tr>
            
        {sales && sales.map((sale,i)=>
        
        <tr key={sale.id}>
          <td>{i+1}</td>          
          <td>{sale.transaction_id}</td>
          <td>{sale.amount_paid}</td>
          <td>{sale.total}</td>
          <td 
             style={{textTransform:"capitalize"}}>{JSON.parse(sale.sale_details).map((sa)=><div key={sa.item_id}>({sa.qty}) {sa.name} @ {sa.price}</div>)}
          </td>
          
          <td style={{display:"none"}}>{totsale+=sale.total}</td>
          <td style={{display:"none"}}>{totpaid+=sale.amount_paid}</td>
          <td style={{display:"none"}}></td>
        </tr>
        
        )}


<tr>
          <th></th>
          <th>TOTAL</th>          
          
          <th>{totpaid}</th>
          <th>{totsale}</th>
          <th></th>
        </tr>

</tbody></table>
      </div>
        </div>
        
        </>
    )
}

export default SalesReport

