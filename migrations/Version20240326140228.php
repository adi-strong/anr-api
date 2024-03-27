<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326140228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, god_father_id INT DEFAULT NULL, grade_id INT DEFAULT NULL, department_id INT DEFAULT NULL, service_id INT DEFAULT NULL, job_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, register VARCHAR(255) NOT NULL, cart_number VARCHAR(255) DEFAULT NULL, pseudo VARCHAR(255) NOT NULL, sex VARCHAR(1) DEFAULT NULL, marital_status VARCHAR(8) DEFAULT NULL, born_at DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, origin VARCHAR(255) NOT NULL, father VARCHAR(255) DEFAULT NULL, mother VARCHAR(255) DEFAULT NULL, conjoint VARCHAR(255) DEFAULT NULL, children JSON DEFAULT NULL, blood VARCHAR(255) NOT NULL, level_of_studies VARCHAR(255) NOT NULL, god_father_num VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_268B9C9D487CFC8E (god_father_id), INDEX IDX_268B9C9DFE19A1A8 (grade_id), INDEX IDX_268B9C9DAE80F5DF (department_id), INDEX IDX_268B9C9DED5CA9E6 (service_id), INDEX IDX_268B9C9DBE04EA9 (job_id), INDEX IDX_268B9C9DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D487CFC8E FOREIGN KEY (god_father_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DED5CA9E6 FOREIGN KEY (service_id) REFERENCES department_service (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D487CFC8E');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DFE19A1A8');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DAE80F5DF');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DED5CA9E6');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DBE04EA9');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DA76ED395');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE doc_object');
    }
}
