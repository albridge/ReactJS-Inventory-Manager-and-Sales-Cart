const express = require('express');
const mysql = require('mysql');
const cors = require('cors');

const db = mysql.createConnection({
    'user': 'root',
    'password': 'atteni',
    'database': 'reactsale'
});



const app = express();
app.use(express.json());
app.use(cors());

app.post('/add', (req, res) => {

    let item_name = req.body.item_name;
    let price = req.body.price;
    let quantity = req.body.quantity;
    let re_order = req.body.re_order;
    let supply_price = req.body.supply_price;

    db.query("insert into inventory (item_name,price,quantity,re_order,supply_price) values(?,?,?,?,?)", [item_name, price, quantity, re_order, supply_price], (err, result) => {
        if (err) {
            console.log(err);
        }
        // return res.send({ result });
        // return res.send({ "id": result.insertId, "text": text, "day": day, "reminder": rem });
        // console.log(result);
    });
});


// post sales from cart

app.post('/checkout', (req, res) => {

    let today = new Date();
    let dd = String(today.getDate()).padStart(2,'0');
    let mm = String(today.getMonth()+1).padStart(2,'0');
    let yyyy = today.getFullYear();
    let created_at = yyyy+'-'+mm+'-'+dd;
    let dtotal=0;
    let transaction = + new Date();

    let reqTotal=0;
    // console.log(req.body);  return;
    
    req.body.map((re)=>reqTotal+=re.qty*re.price);

    
    
    let theme=[];
    
    // let details = req.body.map((r)=>{  theme+=[r.item_name,r.qty,r.price,r.item_id]; return theme; })
    // // let details = req.body.map((r)=>{  theme+=`[{name:${r.item_name}]`; return theme; })

    const getDetails = (items) =>
    {
        for(let i=0; i<items.length; i++)
        {            
            theme[i]={name:items[i].item_name,item_id:items[i].id,price:items[i].price,qty:items[i].qty};
        }
        return theme;
       
    }
    // console.log(JSON.stringify(getDetails(req.body))); 
    // return;

    let details=JSON.stringify(getDetails(req.body));


    
    // console.log('body is',req.body[0].payment); return;
    
    // for(var m=0; m<(req.body).length; m++)
    // {
    //     let item_id = req.body[m].id
    //     let item_name = req.body[m].item_name;
    //     let qty = req.body[m].qty;
    //     let price = req.body[m].price;  
    //     let amount_paid = req.body[m].payment;         
    //     let transaction_id = transaction;
    //     let total = reqTotal;
    //     let sale_details = details
       
        

    //     db.query("insert into sales (item_id,item_name,qty,price,total,amount_paid,transaction_id,sale_details,created_at) values(?,?,?,?,?,?,?,?,?)", [item_id,item_name,qty,price,total,amount_paid,transaction_id,sale_details,created_at], (err, result) => {
    //         if (err) {
    //             // console.log(err);
    //             throw err;
    //         }          
            
    //     });
    // }   
    
    

   
               
        let amount_paid = req.body[0].payment;         
        let transaction_id = transaction;
        let total = reqTotal;
        let sale_details = details
       
        

        db.query("insert into sales (total,amount_paid,transaction_id,sale_details,created_at) values(?,?,?,?,?)", [total,amount_paid,transaction_id,sale_details,created_at], (err, result) => {
            if (err) {
                // console.log(err);
                throw err;
            } 
            
                req.body.forEach((bo)=>{
                    let newQuantity=bo.quantity-bo.qty;
                    let query = "update inventory set quantity='"+newQuantity+"' where id='"+bo.id+"'";    
                    db.query(query,(err,result) => {
                        if(err)
                        {
                            throw err
                        }
                        // res.header("Access-Control-Allow-Origin", "*");
                        // return res.send(result);
                        
                    });
                })
            
        });
   

            if(res.statusCode === 200) {
                res.send('200');              
                
            }  
    
});


app.get('/select', (req, res) => {
    let query = "select *from inventory";    
    db.query(query,(err,result) => {
        if(err)
        {
            console.log(err);
        }
        res.header("Access-Control-Allow-Origin", "*");
        return res.send(result);
    });
});

// load inventory

app.get('/inventory', (req, res) => {
    let query = "select *from inventory";    
    db.query(query,(err,result) => {
        if(err)
        {
            console.log(err);
        }
        res.header("Access-Control-Allow-Origin", "*");
        return res.send(result);
    });
});

// fetch single item details

app.get('/getItem', (req, res) => {
    // let id = new URLSearchParams('item_id');
    // let id = req.params.item_id;
    let id = req.query.item_id;
    let query = "select *from inventory where id='"+id+"'";    
    db.query(query,(err,result) => {
        if(err)
        {
            console.log(err);
        }
        res.header("Access-Control-Allow-Origin", "*");
        return res.send(result);
    });
});


// fetch items that match date

app.get('/getItems', (req, res) => {
    // let id = new URLSearchParams('item_id');
    // let id = req.params.item_id;
    let ddate = req.query.item_id;
    let ddate2 = req.query.endate;
    // console.log(ddate);
    
    let query = "select *from sales where substr(created_at,1,10)>='"+ddate+"' && substr(created_at,1,10)<='"+ddate2+"'";    
    db.query(query,(err,result) => {
        if(err)
        {
            console.log(err);
        }
        res.header("Access-Control-Allow-Origin", "*");
        return res.send(result);
    });
});


// fetch single inventory for edit

app.get('/getEdit', (req, res) => {
    // let id = new URLSearchParams('item_id');
    // let id = req.params.item_id;
    let id = req.query.item_id;
    let query = "select *from inventory where id='"+id+"'";    
    db.query(query,(err,result) => {
        if(err)
        {
            console.log(err);
        }
        res.header("Access-Control-Allow-Origin", "*");
        return res.send(result);
    });
});


// update inventory item details
app.put('/updateInv', (req, res) => {    
    
    let id=req.body.editId;

    if(req.body.editQuantity.length===0){
        req.body.editQuantity=req.body.old.oldQuantity;
    }    
    let quantity=req.body.editQuantity;

    if(req.body.editPrice.length===0){
        req.body.editPrice=req.body.old.oldPrice;
    }
    let price=req.body.editPrice;

    if(req.body.editReOrder.length===0){
        req.body.editReOrder=req.body.old.oldReOrder;
    }
    let reorder =req.body.editReOrder;

    if(req.body.editItemName.length===0){
        req.body.editItemName=req.body.old.oldItemName;
    }
    let itemName=req.body.editItemName;


    
    
    
    
    db.query("update inventory set quantity=?, price=?, re_order=?, item_name=? where id=?",[quantity,price,reorder,itemName,id],(err,result) => {           
        if(err)
        {
            console.log(err);
        }        
        // return res.send({"id":id,"price":price,"quantity":quantity,"reorder":reorder,"itemName":itemName});        
    });

});



app.listen(4001, () => {
    console.log('reactsale server connected');
});