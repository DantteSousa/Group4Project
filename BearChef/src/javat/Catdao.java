package javat;

import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Component;
import org.springframework.stereotype.Service;

import javax.swing.tree.RowMapper;
import java.sql.SQLException;
import java.util.List;
import java.util.Map;

//@Autowired
@Component
@Service
public class Catdao {

    JdbcTemplate template;
    public Catdao(JdbcTemplate template){
        this.template = template;
    }

    public void setTemplate(JdbcTemplate template) {
        this.template = template;
    }

    public List<Category> display() throws ClassNotFoundException, SQLException{
        return template.query("select * from category", (rs,row) -> {
            
            //Create an array list that will contain the data recovered
            Category c = new Category();
            c.setCatcode(rs.getString(1));
            c.setCatdesc(rs.getString(2));
            return c;
        });
    }

    public int insertData(final Category category){
        return template.update("insert into category values(?,?)",category.getCatcode(),category.getCatdesc());
    }

    public int deleteData(String cat){
        return template.update("delete from category where catcode= ?", cat);
    }

    public int editData(final Category category, String cat){
        return template.update("update category set catcode= ?, catdesc= ? where catcode= ?",category.getCatcode(),category.getCatdesc(),cat);
    }

    //Check if the date is already existing
    public List<Map<String,Object>> getcat(String cat){
        return template.queryForList("SELECT  * FROM category WHERE catcode= ?", cat);
    }

    //Search the items table for existing items belonging to a category
    public List<Map<String,Object>>getitem(String cat){
        return template.queryForList("SELECT * from items WHERE catcode= ?", cat);
    }
}

