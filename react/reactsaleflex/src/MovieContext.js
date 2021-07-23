import React, {useState, createContext} from "react"

export const MovieContext = createContext();
export const MovieProvider = (props) =>{
    
        const [movies,setMovies] = useState(
            [
                {
                    name:"Harry Potter",
                    price:"$200",
                    id:1
                },
                {
                    name:"Octopussy",
                    price:"$100",
                    id:1
                },
                {
                    name:"The Hidden",
                    price:"$50",
                    id:1
                }
            ]
        )
        
    return(
<MovieContext.Provider value={[movies,setMovies]}>
{props.children}
</MovieContext.Provider>
    );
}