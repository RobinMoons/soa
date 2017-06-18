import javax.servlet.Servlet;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.*;


import com.google.appengine.api.datastore.*;
import com.google.appengine.labs.repackaged.org.json.JSONException;
import com.google.appengine.labs.repackaged.org.json.JSONObject;

import static com.google.appengine.api.datastore.Query.*;

// Juiste voorbeelden Voorbeelden
//https://github.com/GoogleCloudPlatform/java-docs-samples/blob/master/appengine/datastore/indexes-perfect/src/main/java/com/example/appengine/IndexesServlet.java

/**
 * Created by Robin on 15/05/2017.
 */
public class DataStoreServlet_getData extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        //een POST request wordt hetzelfde afgehandeld als een GET
        doGet(request,response);
    }
    // if user has 'get' rights, return distributor info
    // http://usermanager-167313.appspot.com/getData?&key=5657382461898752&distributor=Engie
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        response.setHeader("Access-Control-Allow-Origin", "*");
        response.setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
        response.setContentType("application/json");
        response.setCharacterEncoding("utf-8");
        PrintWriter out = response.getWriter();
        JSONObject json = new JSONObject();

        //haal parameters op uit de request
        String pKey = request.getParameter("key");
        String pDistributor = request.getParameter("distributor");
        DatastoreService datastore = DatastoreServiceFactory.getDatastoreService();

        try
        {
            Long keyId = Long.parseLong(pKey);
            Key parentKey = KeyFactory.createKey("users","create");
            Key key = KeyFactory.createKey(parentKey,"users",keyId);
            FilterPredicate keyFilter = new FilterPredicate(Entity.KEY_RESERVED_PROPERTY, FilterOperator.EQUAL, key);
            Query q = new Query("users").setFilter(keyFilter);

            PreparedQuery pq = datastore.prepare(q);
            Entity gebruiker = pq.asSingleEntity();

            if (gebruiker != null) {
                String acces = gebruiker.getProperty("Rights").toString();
                JSONObject user = new JSONObject();
                try {
                    user.put("Name",gebruiker.getProperty("name"));
                    user.put("First_name", gebruiker.getProperty("firstName"));
                    user.put("Acces_rights", acces);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                if (acces.equals("get")|| acces.equals("both")) {
                    if(! pDistributor.equals("all") ){
                        FilterPredicate nameFilter = new FilterPredicate("dist. name", FilterOperator.EQUAL, pDistributor);
                        Query qu = new Query("providers").setFilter(nameFilter);
                        PreparedQuery pqu = datastore.prepare(qu);
                        Entity distributor = pqu.asSingleEntity();
                        if (distributor != null){
                            Double dag = (Double)distributor.getProperty("Dagtarief");
                            Double nacht = (Double)distributor.getProperty("Nachttarief");
                            Double groen = (Double)distributor.getProperty("Kost Groen");
                            Double normaal = (Double)distributor.getProperty("Normaaltarief");
                            String name =  distributor.getProperty("dist. name").toString();
                            try {
                                json.put("message","succes");
                                json.put("User info", user);
                                JSONObject dist = new JSONObject();
                                dist.put("Distributor",name);
                                dist.put("Dagtarief",dag);
                                dist.put("Nachttarief", nacht);
                                dist.put("Groenkost", groen);
                                dist.put("Normaal_tarief", normaal);
                                json.put("Distributor_info", dist);
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }
                        else{
                            try {
                                json.put("message","Distributor not found");
                                json.put("User_info", user);
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                            //response.getWriter().print("distributor not found!");
                        }
                    }
                    else {
                        Query namequery = new Query("providers");
                        PreparedQuery prepNamequery = datastore.prepare(namequery);
                        Iterator<Entity> providers = prepNamequery.asIterator();
                        JSONObject prov = new JSONObject();
                        List<Entity> results = datastore.prepare(namequery).asList(FetchOptions.Builder.withDefaults());
                        for (int i = 0; i < results.size(); i++){
                            String name = "name " + Integer.toString(i+1);
                            try {
                                prov.put(name, results.get(i).getProperty("dist. name").toString());
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }

                        try {
                            json.put("Providers",prov);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }
                else {
                    try {
                        json.put("message","Acces denied");
                        json.put("User_info", user);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    //response.getWriter().print("No 'get' rights for this user");
                }
            }
            else {
                try {
                    json.put("message","Invalid API key");
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                //response.getWriter().print("user not found!");
            }
        }
        catch (Exception ex){
            try {
                json.put("Error",ex.toString());
                json.put("Explanation", "Bad request");
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }


        out.print(json);
    }
    protected void doOptions(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{
        //Tell the browser what requests we allow.
        response.setHeader("Access-Control-Allow-Origin", "*");
        response.setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
        response.setContentType("application/json");
        response.setCharacterEncoding("utf-8");
        JSONObject methods = new JSONObject();
        try {
            JSONObject paramKey = new JSONObject();
            paramKey.put("type", "string");
            paramKey.put("description", "API key to acces data");
            paramKey.put("required", true);
            JSONObject paramDist = new JSONObject();
            paramDist.put("type", "string");
            paramDist.put("description", "Distributor name; 'all' returns list of available distributors");
            paramDist.put("required", true);
            JSONObject parameters = new JSONObject();
            parameters.put("key", paramKey);
            parameters.put("distributor", paramDist);
            JSONObject postmethod = new JSONObject();
            postmethod.put("description", "Get pricing data from electrical distributors");
            postmethod.put("parameters", parameters);
            methods.put("POST",postmethod);
            JSONObject getmethod = new JSONObject();
            getmethod.put("parameters", "ref. POST");
            getmethod.put("Example_URL", "http://usermanager-167313.appspot.com/getData?&key=API_KEY&distributor=DistributorName");
            methods.put("GET", getmethod);
            methods.put("OPTIONS", "info page");
        } catch (JSONException e) {
            e.printStackTrace();
        }
        response.getWriter().print(methods);
    }
    /*
    protected void doPut(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{

    }
    protected void doDelete(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{

    }
    protected void doHead(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{

    }

    protected void doTrace(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{

    }
    */
}
